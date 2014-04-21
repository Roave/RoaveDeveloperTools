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
use Roave\DeveloperTools\Inspection\CounterInspection;
use Roave\DeveloperTools\Inspector\CounterInspector;
use Zend\EventManager\EventInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Inspector\CounterInspector}
 *
 * @covers \Roave\DeveloperTools\Inspector\CounterInspector
 */
class CounterInspectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CounterInspector
     */
    private $inspector;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->inspector = new CounterInspector();
    }

    public function testInspectsCounter()
    {

        $inspection = $this->inspector->inspect($this->getMock(EventInterface::class));

        $this->assertInstanceOf(CounterInspection::class, $inspection);
        $this->assertSame(1, $inspection->getInspectionData()[CounterInspection::PARAM_COUNT]);
    }

    public function testInspectsIncrementalCounterValues()
    {

        $event = $this->getMock(EventInterface::class);

        $this->assertSame(1, $this->inspector->inspect($event)->getInspectionData()[CounterInspection::PARAM_COUNT]);
        $this->assertSame(2, $this->inspector->inspect($event)->getInspectionData()[CounterInspection::PARAM_COUNT]);
        $this->assertSame(3, $this->inspector->inspect($event)->getInspectionData()[CounterInspection::PARAM_COUNT]);
    }

    public function testReset()
    {

        $event = $this->getMock(EventInterface::class);

        $this->assertSame(1, $this->inspector->inspect($event)->getInspectionData()[CounterInspection::PARAM_COUNT]);
        $this->assertSame(2, $this->inspector->inspect($event)->getInspectionData()[CounterInspection::PARAM_COUNT]);

        $this->inspector->reset();

        $this->assertSame(1, $this->inspector->inspect($event)->getInspectionData()[CounterInspection::PARAM_COUNT]);
    }
}
