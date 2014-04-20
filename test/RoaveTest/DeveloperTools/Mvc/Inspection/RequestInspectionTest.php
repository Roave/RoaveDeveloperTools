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

use Roave\DeveloperTools\Mvc\Inspection\RequestInspection;
use RoaveTest\DeveloperTools\Inspection\AbstractInspectionTest;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\Request;
use Zend\Stdlib\RequestInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Inspection\RequestInspection}
 *
 * @covers \Roave\DeveloperTools\Mvc\Inspection\RequestInspection
 */
class RequestInspectionTest extends AbstractInspectionTest
{
    /**
     * @param RequestInterface $request
     *
     * @dataProvider requestProvider
     */
    public function testGetData(RequestInterface $request)
    {
        $this->assertEquals(
            $request,
            (new RequestInspection($request))->getInspectionData()[RequestInspection::DATA_REQUEST]
        );
    }

    /**
     * @return RequestInterface[][]
     */
    public function requestProvider()
    {
        return [
            [$this->getMock(RequestInterface::class)],
            [$this->getMock(Request::class)],
            [$this->getMock(ConsoleRequest::class, [], [], '', false)],
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getInspection()
    {
        return new RequestInspection($this->getMock(RequestInterface::class));
    }
}
