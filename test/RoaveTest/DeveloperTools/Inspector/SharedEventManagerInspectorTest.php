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
use Roave\DeveloperTools\Inspector\SharedEventManagerInspector;
use Zend\EventManager\Event;
use Zend\EventManager\EventInterface;
use Zend\EventManager\SharedEventManagerInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Inspector\SharedEventManagerInspector}
 *
 * @covers \Roave\DeveloperTools\Inspector\SharedEventManagerInspector
 */
class SharedEventManagerInspectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SharedEventManagerInspector
     */
    private $inspector;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $sharedEvm = $this->getMock(SharedEventManagerInterface::class);

        $sharedEvm
            ->expects($this->exactly(2))
            ->method('attach')
            ->with(
                '*',
                '*',
                $this->isType('callable'),
                $this->isType('integer')
            );

        $this->inspector = new SharedEventManagerInspector($sharedEvm);
    }

    public function testInspectWithNoTriggeredEvents()
    {
        $this->assertEmpty($this->inspector->inspect($this->getMock(EventInterface::class))->getInspectionData());
    }

    public function testInspectWithTriggeredEvents()
    {
        $event = new Event('foo');

        $this->inspector->onEventStart($event);

        $this->assertCount(1, $this->inspector->inspect($this->getMock(EventInterface::class))->getInspectionData());
        $this->assertEmpty($this->inspector->inspect($this->getMock(EventInterface::class))->getInspectionData());

        $params = $event->getParams();

        $this->assertCount(1, $params);
        $this->assertInternalType('string', reset($params));
    }

    public function testInspectWithSameEvent()
    {
        $event = new Event('foo');

        $this->inspector->onEventStart($event);
        $this->inspector->onEventEnd($event);

        $inspectionData = $this->inspector->inspect($this->getMock(EventInterface::class))->getInspectionData();

        $this->assertCount(2, $inspectionData);
        $this->assertEmpty($this->inspector->inspect($this->getMock(EventInterface::class))->getInspectionData());;

        $this->assertSame(
            $inspectionData[0]->getInspectionData()['eventId'],
            $inspectionData[1]->getInspectionData()['eventId']
        );
    }
}
