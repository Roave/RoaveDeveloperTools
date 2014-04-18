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

namespace RoaveFunctionalTest\DeveloperTools;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Mvc\Listener\ApplicationInspectorListener;
use RoaveFunctionalTest\DeveloperTools\Util\ServiceManagerFactory;
use Zend\Console\Console;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;

/**
 * Functional tests for {@see \Roave\DeveloperTools\Module}
 *
 * @coversNothing
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        Console::overrideIsConsole(true);
    }

    public function testSavesApplicationRunTime()
    {
        $serviceManager = ServiceManagerFactory::getServiceManager();

        /* @var $application \Zend\Mvc\Application */
        $application = $serviceManager->get('Application');

        // Prevent the application from stopping (sendResponse indeed stops the application)
        $application->getEventManager()->attach(
            MvcEvent::EVENT_FINISH,
            function (EventInterface $event) {
                $event->stopPropagation(true);
            },
            -1000
        );

        $application->bootstrap()->run();

        $event  = $application->getMvcEvent();

        $inspection   = $event->getParam(ApplicationInspectorListener::PARAM_INSPECTION);
        $inspectionId = $event->getParam(ApplicationInspectorListener::PARAM_INSPECTION_ID);

        $this->assertInstanceOf(InspectionInterface::class, $inspection);
        $this->assertInternalType('string', $inspectionId);
    }


    public function testRendersToolbarInWebApplication()
    {
        Console::overrideIsConsole(false);
        $serviceManager = ServiceManagerFactory::getServiceManager();

        /* @var $application \Zend\Mvc\Application */
        $application = $serviceManager->get('Application');

        // Prevent the application from stopping (sendResponse indeed stops the application)
        $application->getEventManager()->attach(
            MvcEvent::EVENT_FINISH,
            function (EventInterface $event) {
                $event->stopPropagation(true);
            },
            -1000
        );

        $this->markTestIncomplete('Requires some sample app config to run');

        $application->bootstrap()->run();

        $event  = $application->getMvcEvent();

        $response = $application->getResponse();
    }
}
