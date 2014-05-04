<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Roave\DeveloperTools\Renderer;

use Roave\DeveloperTools\Inspection\AggregateInspection;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * Renderer that can produce a complex view model from an aggregate renderer by leveraging
 * multiple other inspection renderers
 */
abstract class BaseAggregateInspectionRenderer extends BaseInspectionRenderer
{
    const PARAM_DETAIL_MODELS   = 'detailModels';
    const PARAM_MODEL           = 'model';
    const PARAM_MODEL_VARIABLES = 'modelVariables';
    const PARAM_MODEL_TEMPLATE  = 'modelTemplate';
    const PARAM_MODEL_CLASS     = 'modelClass';

    /**
     * {@inheritDoc}
     */
    protected $supportedInspection = AggregateInspection::class;

    /**
     * @var InspectionRendererInterface[]
     */
    private $detailRenderers;

    /**
     * @param InspectionRendererInterface[] $detailRenderers
     */
    public function __construct($detailRenderers)
    {
        $this->detailRenderers = array_map(
            function (InspectionRendererInterface $renderer) {
                return $renderer;
            },
            ArrayUtils::iteratorToArray($detailRenderers)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function render(InspectionInterface $inspection)
    {
        // produce an empty array for every detail renderer
        $rendererResults = array_map(
            function () {
                return [];
            },
            $this->detailRenderers
        );

        $viewModel = parent::render($inspection);

        /* @var $inspection AggregateInspection */
        foreach ($inspection->getInspectionData() as $childInspection) {
            foreach ($this->detailRenderers as $index => $renderer) {
                if (! $renderer->canRender($childInspection)) {
                    continue;
                }

                $rendererResult            = $renderer->render($childInspection);
                $rendererResults[$index][] = [
                    static::PARAM_MODEL           => $rendererResult,
                    static::PARAM_MODEL_VARIABLES => ArrayUtils::iteratorToArray($rendererResult->getVariables()),
                    static::PARAM_MODEL_TEMPLATE  => $rendererResult->getTemplate(),
                    static::PARAM_MODEL_CLASS     => get_class($rendererResult),
                ];

                $viewModel->addChild($rendererResult);
            }
        }

        return $viewModel
            ->setVariable(static::PARAM_INSPECTION_DATA, $this->expandAggregateInspectionData($inspection))
            ->setVariable(static::PARAM_DETAIL_MODELS, $rendererResults);
    }

    /**
     * Expand the data from an aggregate inspection recursively, providing useful data for
     * the produced view model
     *
     * @param InspectionInterface $inspection
     *
     * @return array|mixed[]|\Traversable
     */
    protected function expandAggregateInspectionData(InspectionInterface $inspection)
    {
        if ($inspection instanceof AggregateInspection) {
            return array_map(
                function (InspectionInterface $inspection) {
                    return [
                        static::PARAM_INSPECTION       => $inspection,
                        static::PARAM_INSPECTION_DATA  => $this->expandAggregateInspectionData($inspection),
                        static::PARAM_INSPECTION_CLASS => get_class($inspection),
                    ];
                },
                $inspection->getInspectionData()
            );
        }

        return $inspection->getInspectionData();
    }
}
