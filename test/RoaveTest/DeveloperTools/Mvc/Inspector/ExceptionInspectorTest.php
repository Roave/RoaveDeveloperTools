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

namespace RoaveTest\DeveloperTools\Mvc\Inspector;

use Exception;
use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Inspection\ExceptionInspection;
use Roave\DeveloperTools\Inspection\NullInspection;
use Roave\DeveloperTools\Mvc\Inspector\ExceptionInspector;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Inspector\ExceptionInspector}
 *
 * @covers \Roave\DeveloperTools\Mvc\Inspector\ExceptionInspector
 */
class ExceptionInspectorTest extends PHPUnit_Framework_TestCase
{
    public function testInspectWithException()
    {
        $event = $this->getMock(MvcEvent::class);

        $event
            ->expects($this->any())
            ->method('getParam')
            ->with('exception')
            ->will($this->returnValue(new Exception()));

        $inspector = new ExceptionInspector();

        $this->assertInstanceOf(ExceptionInspection::class, $inspector->inspect($event));
    }

    public function testInspectWithInvalidEventType()
    {
        $event = $this->getMock(EventInterface::class);

        $event
            ->expects($this->any())
            ->method('getParam')
            ->with('exception')
            ->will($this->returnValue(new Exception()));

        $inspector = new ExceptionInspector();

        $this->assertInstanceOf(NullInspection::class, $inspector->inspect($event));
    }

    public function testInspectWithoutApplicationException()
    {
        $event = $this->getMock(MvcEvent::class);

        $inspector = new ExceptionInspector();

        $this->assertInstanceOf(NullInspection::class, $inspector->inspect($event));
    }
}
