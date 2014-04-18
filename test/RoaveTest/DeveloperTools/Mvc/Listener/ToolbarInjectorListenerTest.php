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

namespace RoaveTest\DeveloperTools\Inspector;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Inspector\InspectorInterface;
use Roave\DeveloperTools\Mvc\Listener\ApplicationInspectorListener;
use Roave\DeveloperTools\Mvc\Listener\ToolbarInjectorListener;
use Roave\DeveloperTools\Renderer\InspectionRendererInterface;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Renderer\RendererInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Listener\ToolbarInjectorListener}
 *
 * @covers \Roave\DeveloperTools\Mvc\Listener\ToolbarInjectorListener
 */
class ToolbarInjectorListenerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ToolbarInjectorListener
     */
    private $listener;

    /**
     * @var MvcEvent|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mvcEvent;

    /**
     * @var RendererInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $renderer;

    /**
     * @var InspectionRendererInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $inspectionRenderer;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->mvcEvent           = $this->getMock(MvcEvent::class);
        $this->renderer           = $this->getMock(RendererInterface::class);
        $this->inspectionRenderer = $this->getMock(InspectionRendererInterface::class);
        $this->listener           = new ToolbarInjectorListener($this->renderer, $this->inspectionRenderer);
    }

    public function testListenerTriggeringWithInvalidMvcEventData()
    {
        $this->markTestIncomplete();
    }

    public function testAttach()
    {
        $eventManager = $this->getMock(EventManagerInterface::class);

        $eventManager->expects($this->once())->method('attach')->with(
            $this->isType('string'),
            $this->isType('callable'),
            $this->isType('integer')
        );

        $this->listener->attach($eventManager);
    }
}
