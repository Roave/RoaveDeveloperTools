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
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Listener\ApplicationInspectorListener}
 *
 * @covers \Roave\DeveloperTools\Mvc\Listener\ApplicationInspectorListener
 */
class ApplicationInspectorListenerTest extends PHPUnit_Framework_TestCase
{
    public function testListenerTriggering()
    {
        $repository    = $this->getMock(InspectionRepositoryInterface::class);
        $event         = $this->getMock(EventInterface::class);
        $inspection    = $this->getMock(InspectionInterface::class);
        $inspector     = $this->getMock(InspectorInterface::class);
        $uuidGenerator = $this->getMock(UUIDGeneratorInterface::class);

        $listener = new ApplicationInspectorListener($repository, $uuidGenerator, $inspector);

        $uuidGenerator->expects($this->any())->method('generateUUID')->will($this->returnValue('123456'));
        $inspector->expects($this->any())->method('inspect')->with($event)->will($this->returnValue($inspection));
        $repository->expects($this->atLeastOnce())->method('add')->with('123456', $inspection);

        $event->expects($this->exactly(2))->method('setParam')->with(
            $this->logicalOr(
                ApplicationInspectorListener::PARAM_INSPECTION,
                ApplicationInspectorListener::PARAM_INSPECTION_ID
            ),
            $this->logicalOr(
                $inspection,
                '123456'
            )
        );

        $this->assertSame('123456', $listener->collectInspectionsOnApplicationFinish($event));
    }

    public function testAttach()
    {
        $eventManager  = $this->getMock(EventManagerInterface::class);
        $repository    = $this->getMock(InspectionRepositoryInterface::class);
        $inspector     = $this->getMock(InspectorInterface::class);
        $uuidGenerator = $this->getMock(UUIDGeneratorInterface::class);

        $listener = new ApplicationInspectorListener($repository, $uuidGenerator, $inspector);

        $eventManager->expects($this->once())->method('attach')->with(
            $this->isType('string'),
            $this->isType('callable'),
            $this->isType('integer')
        );

        $listener->attach($eventManager);
    }
}
