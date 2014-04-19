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
use Roave\DeveloperTools\Mvc\Inspection\ResponseInspection;
use RoaveTest\DeveloperTools\Inspection\AbstractInspectionTest;
use Zend\Console\Response as ConsoleResponse;
use Zend\Http\Response;
use Zend\Stdlib\ResponseInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Inspection\ResponseInspection}
 *
 * @covers \Roave\DeveloperTools\Mvc\Inspection\ResponseInspection
 */
class ResponseInspectionTest extends AbstractInspectionTest
{
    /**
     * @param ResponseInterface $response
     *
     * @dataProvider responseProvider
     */
    public function testGetData(ResponseInterface $response)
    {
        $this->assertEquals(
            $response,
            (new ResponseInspection($response))->getInspectionData()[ResponseInspection::DATA_RESPONSE]
        );
    }

    /**
     * @return ResponseInterface[][]
     */
    public function responseProvider()
    {
        return [
            [$this->getMock(ResponseInterface::class)],
            [$this->getMock(Response::class)],
            [$this->getMock(ConsoleResponse::class, [], [], '', false)],
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getInspection()
    {
        return new ResponseInspection($this->getMock(ResponseInterface::class));
    }
}
