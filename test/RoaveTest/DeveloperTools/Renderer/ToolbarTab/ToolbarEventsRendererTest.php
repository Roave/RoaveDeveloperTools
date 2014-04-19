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

namespace RoaveTest\DeveloperTools\Renderer\ToolbarTab;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Inspection\AggregateInspection;
use Roave\DeveloperTools\Inspection\EventInspection;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Inspection\TimeInspection;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarEventsRenderer;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarExceptionRenderer;

/**
 * Tests for {@see \Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarEventsRenderer}
 *
 * @covers \Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarEventsRenderer
 */
class ToolbarEventsRendererTest extends PHPUnit_Framework_TestCase
{
    public function testAcceptsOnlyExceptionInspection()
    {
        $renderer = new ToolbarEventsRenderer();

        $this->assertFalse($renderer->canRender($this->getMock(InspectionInterface::class)));
        $this->assertFalse($renderer->canRender($this->getMock(TimeInspection::class, [], [], '', false)));
        $this->assertFalse($renderer->canRender(new AggregateInspection([])));
        $this->assertFalse($renderer->canRender(
            new AggregateInspection([$this->getMock(TimeInspection::class, [], [], '', false)]))
        );
        $this->assertTrue($renderer->canRender(
            new AggregateInspection([$this->getMock(EventInspection::class, [], [], '', false)]))
        );
    }

    public function testRenderExceptionInspection()
    {
        $renderer   = new ToolbarExceptionRenderer();
        $inspection = new AggregateInspection([$this->getMock(EventInspection::class, [], [], '', false)]);

        $this->assertSame($inspection, $renderer->render($inspection)->getVariable('inspection'));
    }
}
