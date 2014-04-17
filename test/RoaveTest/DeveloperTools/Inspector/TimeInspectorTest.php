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

namespace RoaveTest\DeveloperTools;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Inspection\TimeInspection;
use Roave\DeveloperTools\Inspector\TimeInspector;
use Zend\EventManager\EventInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Inspector\TimeInspector}
 *
 * @covers \Roave\DeveloperTools\Inspector\TimeInspector
 */
class TimeInspectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var TimeInspector
     */
    private $inspector;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->inspector = new TimeInspector();
    }

    /**
     * @covers \Roave\DeveloperTools\Inspector\TimeInspector::inspect
     */
    public function testInspectsTime()
    {
        $inspection = $this->inspector->inspect($this->getMock(EventInterface::class));

        $this->assertInstanceOf(TimeInspection::class, $inspection);
    }

    /**
     * @covers \Roave\DeveloperTools\Inspector\TimeInspector::inspect
     */
    public function testInspectsTimeOnRepeatedCalls()
    {
        $inspection1 = $this->inspector->inspect($this->getMock(EventInterface::class));
        $inspection2 = $this->inspector->inspect($this->getMock(EventInterface::class));

        $this->assertInstanceOf(TimeInspection::class, $inspection1);
        $this->assertInstanceOf(TimeInspection::class, $inspection2);
        $this->assertNotSame($inspection1, $inspection2);
    }

    /**
     * @covers \Roave\DeveloperTools\Inspector\TimeInspector::inspect
     */
    public function testEndTimeIsDouble()
    {
        $inspection1 = $this->inspector->inspect($this->getMock(EventInterface::class));
        $inspection2 = $this->inspector->inspect($this->getMock(EventInterface::class));

        $this->assertInternalType('float', $inspection1->getInspectionData()[TimeInspection::PARAM_END]);
        $this->assertInternalType('float', $inspection2->getInspectionData()[TimeInspection::PARAM_END]);
    }

    /**
     * @covers \Roave\DeveloperTools\Inspector\TimeInspector::inspect
     */
    public function testInspectedTimeDifferentOnSubsequentCalls()
    {
        $inspection1 = $this->inspector->inspect($this->getMock(EventInterface::class));
        $inspection2 = $this->inspector->inspect($this->getMock(EventInterface::class));

        $this->assertGreaterThan(
            $inspection1->getInspectionData()[TimeInspection::PARAM_END],
            $inspection2->getInspectionData()[TimeInspection::PARAM_END]
        );
    }
}
