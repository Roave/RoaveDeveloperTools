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

namespace RoaveTest\DeveloperTools\Inspection;

use Roave\DeveloperTools\Inspection\EventInspection;
use Zend\EventManager\EventInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Inspection\EventInspection}
 *
 * @covers \Roave\DeveloperTools\Inspection\EventInspection
 */
class EventInspectionTest extends AbstractInspectionTest
{
    public function testInspection()
    {
        $data = $this->getInspection()->getInspectionData();

        $this->assertSame('event-id', $data['eventId']);
        $this->assertInstanceOf(EventInterface::class, $data['event']);
        $this->assertSame('foo', $data['name']);
        $this->assertSame(['a' => 'b'], $data['params']);
        $this->assertSame(false, $data['propagationIsStopped']);
        $this->assertSame(true, $data['isStart']);
        $this->assertInstanceOf(get_class($this), $data['trace'][1]['object']);
        $this->assertInstanceOf(get_class($this), $data['target']);
        $this->assertInternalType('int', $data['memory']);
        $this->assertInternalType('float', $data['time']);
    }

    /**
     * {@inheritDoc}
     */
    protected function getInspection()
    {
        $event = $this->getMock(EventInterface::class);

        $event->expects($this->any())->method('getName')->will($this->returnValue('foo'));
        $event->expects($this->any())->method('getParams')->will($this->returnValue(['a' => 'b']));
        $event->expects($this->any())->method('getTarget')->will($this->returnValue($this));

        return new EventInspection('event-id', true, $event, debug_backtrace());
    }
}
