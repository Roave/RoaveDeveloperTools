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

namespace Roave\DeveloperTools\Mvc\Listener;

use Roave\DeveloperTools\Inspector\InspectorInterface;
use Roave\DeveloperTools\Renderer\InspectionRendererInterface;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Http\Header\ContentType;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\View\Renderer\RendererInterface;

/**
 * Toolbar injector listener - injects the toolbar into a {@see \Zend\Mvc\Application}'s output
 * if the output looks like HTML
 *
 * Listens to the event {@see \Zend\Mvc\MvcEvent::EVENT_FINISH} and iterates over
 * collectors to produce an aggregate inspection
 */
class ToolbarInjectorListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    const PRIORITY         = -1000;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var InspectionRendererInterface
     */
    private $inspectionRenderer;

    public function __construct(RendererInterface $renderer, InspectionRendererInterface $inspectionRenderer)
    {
        $this->renderer           = $renderer;
        $this->inspectionRenderer = $inspectionRenderer;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_FINISH,
            [$this, 'injectToolbarHtml'],
            static::PRIORITY
        );
    }

    /**
     * Attaches the HTML rendered for the toolbar to the output if the output is recognized as an HTML HTTP response
     *
     * @param MvcEvent $event
     *
     * @return void
     */
    public function injectToolbarHtml(MvcEvent $event)
    {
        if (! $inspection  = $event->getParam(ApplicationInspectorListener::PARAM_INSPECTION)) {
            return;
        }

        $application = $event->getApplication();
        $response    = $application->getResponse();

        if (! $response instanceof Response) {
            return;
        }

        $headers     = $response->getHeaders();
        $contentType = $headers->has('Content-Type');

        if (! $contentType instanceof ContentType) {
            return;
        }

        if (false === strpos(strtolower($contentType->getFieldValue()), 'html')) {
            return;
        }

        $toolbar = 'TOOLBAR';

        $response->setContent(preg_replace('/<\/body>/i', $toolbar . "\n</body>", $response->getBody(), 1));
    }
}
