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

namespace RoaveTest\DeveloperTools\Renderer\Detail;

use Roave\DeveloperTools\Inspection\AggregateInspection;
use Roave\DeveloperTools\Inspection\EventInspection;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Inspection\TimeInspection;
use Roave\DeveloperTools\Renderer\Detail\DetailEventsRenderer;
use RoaveTest\DeveloperTools\Renderer\BaseInspectionRendererTest;
use Zend\EventManager\EventManagerInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Renderer\Detail\DetailEventsRenderer}
 *
 * @covers \Roave\DeveloperTools\Renderer\Detail\DetailEventsRenderer
 */
class DetailEventsRendererTest extends BaseInspectionRendererTest
{
    /**
     * {@inheritDoc}
     */
    public function getRenderer()
    {
        return new DetailEventsRenderer();
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportedInspections()
    {
        return [[new AggregateInspection([$this->getMock(EventInspection::class, [], [], '', false)])]];
    }

    public function testRenderProducesSimpleEventsHierarchyArray()
    {
        $eventInspection1 = $this->getMock(EventInspection::class, [], [], '', false);

        $eventInspection1->expects($this->any())->method('getInspectionData')->will($this->returnValue([]));

        $inspection = new AggregateInspection([
            $this->getMock(EventInspection::class, [], [], '', false)
        ]);
        $viewModel  = $this->getRenderer()->render($inspection);

        $this->assertInternalType('array', $viewModel->getVariable(DetailEventsRenderer::PARAM_EVENTS_HIERARCHY));

    }

    public function testRenderProducesNestedEventsHierarchy()
    {
        $eventInspection1 = $this->getMock(EventInspection::class, [], [], '', false);
        $eventInspection2 = $this->getMock(EventInspection::class, [], [], '', false);
        $eventInspection3 = $this->getMock(EventInspection::class, [], [], '', false);
        $eventManager     = $this->getMock(EventManagerInterface::class);

        $eventInspection1->expects($this->any())->method('getInspectionData')->will($this->returnValue([
            'eventId' => 'id1',
            'isStart' => true,
            'time'    => 1,
            'trace'   => [
                [
                    'file'     => 'level0',
                    'line'     => 1,
                    'object'   => $eventManager,
                    'function' => 'trigger',
                ],
            ],
        ]));
        $eventInspection2->expects($this->any())->method('getInspectionData')->will($this->returnValue([
            'eventId' => 'id2',
            'isStart' => true,
            'time'    => 2,
            'trace'   => [
                [
                    'file'     => 'level1',
                    'line'     => 1,
                    'object'   => $eventManager,
                    'function' => 'trigger',
                ],
                [
                    'file'     => 'level0',
                    'line'     => 1,
                    'object'   => $eventManager,
                    'function' => 'trigger',
                ],
            ],
        ]));
        $eventInspection3->expects($this->any())->method('getInspectionData')->will($this->returnValue([
            'eventId' => 'id3',
            'isStart' => true,
            'time'    => 3,
            'trace'   => [
                [
                    'file'     => 'level2',
                    'line'     => 1,
                    'object'   => $eventManager,
                    'function' => 'trigger',
                ],
                [
                    'file'     => 'level1',
                    'line'     => 1,
                    'object'   => $eventManager,
                    'function' => 'trigger',
                ],
                [
                    'file'     => 'level0',
                    'line'     => 1,
                    'object'   => $eventManager,
                    'function' => 'trigger',
                ],
            ],
        ]));

        $inspection = new AggregateInspection([$eventInspection1, $eventInspection2, $eventInspection3]);

        $viewModel = $this->getRenderer()->render($inspection);

        $this->assertEquals(
            [
                'id1' => [
                    'id2' => [
                        'id3' => [],
                    ],
                ],
            ],
            $viewModel->getVariable(DetailEventsRenderer::PARAM_EVENTS_HIERARCHY)
        );
    }

    public function testRendererProducesIndexedInspections()
    {
        $eventInspection1 = $this->getMock(EventInspection::class, [], [], '', false);
        $eventInspection2 = $this->getMock(EventInspection::class, [], [], '', false);
        $eventInspection3 = $this->getMock(EventInspection::class, [], [], '', false);

        $eventInspection1->expects($this->any())->method('getInspectionData')->will($this->returnValue([
            'eventId' => 'id1',
            'isStart' => true,
            'time'    => 1,
            'trace'   => [],
        ]));
        $eventInspection2->expects($this->any())->method('getInspectionData')->will($this->returnValue([
            'eventId' => 'id2',
            'isStart' => true,
            'time'    => 2,
            'trace'   => [],
        ]));
        $eventInspection3->expects($this->any())->method('getInspectionData')->will($this->returnValue([
            'eventId' => 'id3',
            'isStart' => true,
            'time'    => 3,
            'trace'   => [],
        ]));

        $inspection = new AggregateInspection([$eventInspection1, $eventInspection2, $eventInspection3]);

        $this->assertSame(
            [
                'id1' => $eventInspection1,
                'id2' => $eventInspection2,
                'id3' => $eventInspection3,
            ],
            $this->getRenderer()->render($inspection)->getVariable(DetailEventsRenderer::PARAM_INDEXED_INSPECTIONS)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getUnSupportedInspections()
    {
        return [
            [$this->getMock(InspectionInterface::class)],
            [$this->getMock(TimeInspection::class, [], [], '', false)],
            [new AggregateInspection([])],
        ];
    }
}
