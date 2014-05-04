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
use Roave\DeveloperTools\Mvc\Controller\ListInspectionsController;
use Roave\DeveloperTools\Renderer\InspectionRendererInterface;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Zend\Stdlib\RequestInterface;
use Zend\View\Model\ModelInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Controller\ListInspectionsController}
 *
 * @covers \Roave\DeveloperTools\Mvc\Controller\ListInspectionsController
 */
class ListInspectionsControllerTest extends PHPUnit_Framework_TestCase
{
    public function testDispatch()
    {
        $repository  = $this->getMock(InspectionRepositoryInterface::class);
        $inspection1 = $this->getMock(InspectionInterface::class);
        $inspection2 = $this->getMock(InspectionInterface::class);

        $controller = new ListInspectionsController($repository);

        $repository->expects($this->any())->method('getAll')->will($this->returnValue([$inspection1, $inspection2]));

        $result = $controller->dispatch($this->getMock(RequestInterface::class));

        $this->assertInstanceOf(ModelInterface::class, $result);
        $this->assertSame([$inspection1, $inspection2], $result->getVariable('inspections'));
    }
}
