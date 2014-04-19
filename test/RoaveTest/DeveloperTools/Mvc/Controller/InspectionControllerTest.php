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

namespace RoaveTest\DeveloperTools\Mvc\Inspection;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Mvc\Configuration\RoaveDeveloperToolsConfiguration;
use Roave\DeveloperTools\Mvc\Controller\InspectionController;
use Roave\DeveloperTools\Mvc\Controller\ListInspectionsController;
use Roave\DeveloperTools\Renderer\InspectionRendererInterface;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Stdlib\Exception\BadMethodCallException;
use Zend\Stdlib\RequestInterface;
use Zend\View\Model\ModelInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Controller\InspectionController}
 *
 * @covers \Roave\DeveloperTools\Mvc\Controller\InspectionController
 */
class InspectionControllerTest extends PHPUnit_Framework_TestCase
{
    public function testDispatch()
    {
        $repository      = $this->getMock(InspectionRepositoryInterface::class);
        $renderer        = $this->getMock(InspectionRendererInterface::class);
        $inspection      = $this->getMock(InspectionInterface::class);
        $inspectionModel = $this->getMock(ModelInterface::class);
        $mvcEvent        = $this->getMock(MvcEvent::class);
        $controller      = new InspectionController($repository, $renderer);

        $mvcEvent
            ->expects($this->any())
            ->method('getRouteMatch')
            ->will($this->returnValue(new RouteMatch([InspectionController::INSPECTION_ID => '123'])));

        $repository->expects($this->any())->method('get')->with('123')->will($this->returnValue($inspection));

        $renderer
            ->expects($this->any())
            ->method('render')
            ->with($inspection)
            ->will($this->returnValue($inspectionModel));

        $result = $controller->onDispatch($mvcEvent);

        $this->assertInstanceOf(ModelInterface::class, $result);
        $this->assertSame($inspection, $result->getVariable('inspection'));
        $this->assertSame($inspectionModel, $result->getVariable('inspectionModel'));
    }
}
