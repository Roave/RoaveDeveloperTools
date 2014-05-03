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

namespace Roave\DeveloperTools;

use Roave\DeveloperTools\Mvc\Controller\InspectionController;
use Roave\DeveloperTools\Mvc\Listener\ApplicationInspectorListener;
use Roave\DeveloperTools\Mvc\Listener\ToolbarInjectorListener;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

/**
 * Roave\DeveloperTools module - to be enabled in your application's config
 */
class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        /* @var $application \Zend\Mvc\Application */
        $application                  = $e->getTarget();
        $serviceManager               = $application->getServiceManager();
        /* @var $applicationInspectorListener ApplicationInspectorListener */
        $applicationInspectorListener = $serviceManager->get(ApplicationInspectorListener::class);
        /* @var $toolbarInjectorListener ToolbarInjectorListener */
        $toolbarInjectorListener      = $serviceManager->get(ToolbarInjectorListener::class);
        $eventManager                 = $application->getEventManager();

        $eventManager->attachAggregate($applicationInspectorListener);
        $eventManager->attachAggregate($toolbarInjectorListener);

        $eventManager->getSharedManager()->attach(
            [InspectionController::class],
            MvcEvent::EVENT_DISPATCH,
            function() use ($serviceManager) {
                // @todo this is a side-effect that needs to be introduced to prevent ZF2 from
                //       rendering all view models as JSON.
                // @todo consider removing this and simply returning the JSON responses from the controllers
                /* @var $strategy \Zend\View\Strategy\JsonStrategy */
                $strategy    = $serviceManager->get('ViewJsonStrategy');
                /* @var $viewManager \Zend\Mvc\View\Http\ViewManager */
                $viewManager = $serviceManager->get('HttpViewManager');

                $viewManager->getView()->getEventManager()->attach($strategy);
            }
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }
}
