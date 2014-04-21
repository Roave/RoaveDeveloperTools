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
    const PARAM_DETAIL_MODELS = 'detailModels';

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
    public function canRender(InspectionInterface $inspection)
    {
        return $inspection instanceof AggregateInspection;
    }

    /**
     * {@inheritDoc}
     */
    public function render(InspectionInterface $inspection)
    {
        $rendererResults = array_map(
            function () {
                return [];
            },
            $this->detailRenderers
        );

        $viewModel = parent::render($inspection);

        /* @var $inspection AggregateInspection */
        foreach ($inspection->getInspectionData() as $inspection) {
            foreach ($this->detailRenderers as $index => $renderer) {
                if (! $renderer->canRender($inspection)) {
                    continue;
                }

                $rendererResult            = $renderer->render($inspection);
                $rendererResults[$index][] = $rendererResult;

                $viewModel->addChild($rendererResult);
            }
        }

        return $viewModel->setVariable(static::PARAM_DETAIL_MODELS, $rendererResults);
    }
}
