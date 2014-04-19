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
use Zend\Stdlib\DispatchableInterface;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Model\ViewModel;

/**
 * Controller responsible for viewing details about a single inspection
 */
class InspectionController extends AbstractController
{
    const INSPECTION_ID = 'inspectionId';

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
        $routeMatch   = $e->getRouteMatch();
        $inspectionId = $routeMatch ? $routeMatch->getParam(static::INSPECTION_ID) : null;
        $inspection   = $this->inspectionRepository->get((string) $inspectionId);

        if (! $inspection) {
            throw new \InvalidArgumentException(sprintf(
                'The given inspectionId "%s" could not be matched',
                $inspectionId
            ));
        }

        $viewModel = new ViewModel([
            'inspection'      => $inspection,
            'inspectionModel' => $this->inspectionRenderer->render($inspection),
        ]);

        $viewModel->setTemplate('roave-developer-tools/controller/inspection');

        // @todo ZF2's awesomeness forces us to do this crap (and I'm too sleepy to debug why)
        $e->setResult($viewModel);

        return $viewModel;
    }
}
