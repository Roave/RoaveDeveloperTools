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

namespace RoaveTest\DeveloperTools\Renderer;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Inspection\AggregateInspection;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Inspection\TimeInspection;
use Roave\DeveloperTools\Renderer\BaseInspectionRenderer;
use Roave\DeveloperTools\Renderer\InspectionRendererInterface;
use Zend\View\Model\ModelInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Renderer\BaseInspectionRenderer}
 *
 * @covers \Roave\DeveloperTools\Renderer\BaseInspectionRenderer
 */
class BaseInspectionRendererTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param InspectionInterface $inspection
     *
     * @dataProvider getSupportedInspections
     */
    public function testAcceptedModels(InspectionInterface $inspection)
    {
        $this->assertTrue($this->getRenderer()->canRender($inspection));
    }

    /**
     * @param InspectionInterface|null $inspection
     *
     * @dataProvider getUnSupportedInspections
     */
    public function testRefusedModels(InspectionInterface $inspection = null)
    {
        if (null === $inspection) {
            // just a hack since PHPUnit does not allow empty data providers
            $this->assertNull($inspection, 'Renderer supports all inspection types');

            return;
        }

        $this->assertFalse($this->getRenderer()->canRender($inspection));
    }

    /**
     * @param InspectionInterface $inspection
     *
     * @dataProvider getSupportedInspections
     */
    public function testRender(InspectionInterface $inspection)
    {
        $viewModel = $this->getRenderer()->render($inspection);

        $this->assertInstanceOf(ModelInterface::class, $viewModel);
        $this->assertSame($inspection, $viewModel->getVariable(BaseInspectionRenderer::PARAM_INSPECTION));
    }

    /**
     * @return InspectionRendererInterface
     */
    public function getRenderer()
    {
        return $this->getMockForAbstractClass(BaseInspectionRenderer::class);
    }

    /**
     * @return InspectionInterface[][]
     */
    public function getSupportedInspections()
    {
        return [
            [$this->getMock(InspectionInterface::class)],
            [$this->getMock(TimeInspection::class, [], [], '', false)],
            [$this->getMock(AggregateInspection::class, [], [], '', false)],
        ];
    }

    /**
     * @return InspectionInterface[][]|null[][]
     */
    public function getUnSupportedInspections()
    {
        return [
            [null],
        ];
    }
}
