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
use Zend\View\Model\ViewModel;

/**
 * Toolbar renderer specific for the RoaveDeveloperTools toolbar output
 */
class ToolbarInspectionRenderer implements InspectionRendererInterface
{
    /**
     * @var InspectionRendererInterface[]
     */
    private $tabRenderers;

    /**
     * @param InspectionRendererInterface[] $tabRenderers
     */
    public function __construct($tabRenderers)
    {
        $this->tabRenderers = array_map(
            function (InspectionRendererInterface $renderer) {
                return $renderer;
            },
            ArrayUtils::iteratorToArray($tabRenderers)
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
            $this->tabRenderers
        );

        $viewModel = new ViewModel(['inspection' => $inspection]);

        /* @var $inspection AggregateInspection */
        foreach ($inspection->getInspectionData() as $inspection) {
            foreach ($this->tabRenderers as $index => $renderer) {
                if (! $renderer->canRender($inspection)) {
                    continue;
                }

                $rendererResult            = $renderer->render($inspection);
                $rendererResults[$index][] = $rendererResult;

                $viewModel->addChild($rendererResult);
            }
        }

        $viewModel->setVariable('tabs', $rendererResults);

        $viewModel->setTemplate('roave-developer-tools/toolbar/toolbar');

        return $viewModel;
    }
}
