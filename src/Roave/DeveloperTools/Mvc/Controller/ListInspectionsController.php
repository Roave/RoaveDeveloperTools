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

namespace Roave\DeveloperTools\Mvc\Controller;

use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Renderer\InspectionRendererInterface;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

/**
 * Controller responsible for listing all inspections
 */
class ListInspectionsController extends AbstractController
{
    /**
     * @var InspectionRepositoryInterface
     */
    private $inspectionRepository;

    /**
     * @var InspectionRendererInterface
     */
    private $inspectionRenderer;

    /**
     * @param InspectionRepositoryInterface $inspectionRepository
     * @param InspectionRendererInterface   $inspectionRenderer
     */
    public function __construct(
        InspectionRepositoryInterface $inspectionRepository,
        InspectionRendererInterface $inspectionRenderer
    ) {
        $this->inspectionRepository = $inspectionRepository;
        $this->inspectionRenderer   = $inspectionRenderer;
    }

    /**
     * {@inheritDoc}
     */
    public function onDispatch(MvcEvent $e)
    {
        $inspections = $this->inspectionRepository->getAll();

        $viewModel = new ViewModel([
            'inspections'      => $inspections,
            'inspectionModels' => array_filter(array_map(
                function (InspectionInterface $inspection) {
                    if ($this->inspectionRenderer->canRender($inspection)) {
                        return $this->inspectionRenderer->render($inspection);
                    }
                },
                $inspections
            )),
        ]);

        $viewModel->setTemplate('roave-developer-tools/controller/list-inspections');

        // @todo ZF2's awesomeness forces us to do this crap (and I'm too sleepy to debug why)
        $e->setResult($viewModel);

        return $viewModel;
    }
}
