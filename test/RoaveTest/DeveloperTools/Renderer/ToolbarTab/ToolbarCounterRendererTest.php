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
use Roave\DeveloperTools\Inspection\CounterInspection;
use Roave\DeveloperTools\Inspection\ExceptionInspection;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarCounterRenderer;

/**
 * Tests for {@see \Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarCounterRenderer}
 *
 * @covers \Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarCounterRenderer
 */
class ToolbarCounterRendererTest extends PHPUnit_Framework_TestCase
{
    public function testAcceptsOnlyExceptionInspection()
    {
        $renderer = new ToolbarCounterRenderer();

        $this->assertFalse($renderer->canRender($this->getMock(InspectionInterface::class)));
        $this->assertFalse($renderer->canRender($this->getMock(AggregateInspection::class, [], [], '', false)));
        $this->assertFalse($renderer->canRender($this->getMock(ExceptionInspection::class, [], [], '', false)));
        $this->assertTrue($renderer->canRender($this->getMock(CounterInspection::class, [], [], '', false)));
    }

    public function testRenderExceptionInspection()
    {
        $renderer   = new ToolbarCounterRenderer();
        $inspection = $this->getMock(ExceptionInspection::class, [], [], '', false);

        $this->assertSame($inspection, $renderer->render($inspection)->getVariable('inspection'));
    }
}
