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

use ArrayObject;
use Roave\DeveloperTools\Mvc\Inspection\ConfigInspection;
use RoaveTest\DeveloperTools\Inspection\AbstractInspectionTest;
use Zend\Stdlib\ArrayUtils;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Inspection\ConfigInspection}
 *
 * @covers \Roave\DeveloperTools\Mvc\Inspection\ConfigInspection
 */
class ConfigInspectionTest extends AbstractInspectionTest
{
    /**
     * @param mixed $data
     *
     * @dataProvider configProvider
     */
    public function testGetData($data)
    {
        $inspection = new ConfigInspection($data);

        $data = ArrayUtils::iteratorToArray($data);

        $this->assertEquals($data, $inspection->getInspectionData());
    }

    /**
     * @param mixed $data
     *
     * @dataProvider configProvider
     */
    public function testSerialization($data)
    {
        $inspection = new ConfigInspection($data);

        $this->assertEquals($inspection, unserialize(serialize($inspection)));
    }

    /**
     * @return mixed[][]
     */
    public function configProvider()
    {
        return [
            [[]],
            [[1, 2, 3]],
            [new ArrayObject([1, 2, 3])],
            [[function () {
            }]],
            [[
                'a' => 'b',
                'c' => function () {
                },
                'd' => 'e',
            ]],
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getInspection()
    {
        return new ConfigInspection($this->configProvider());
    }
}
