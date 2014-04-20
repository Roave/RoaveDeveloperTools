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

namespace RoaveTest\DeveloperTools\Stub;

use ArrayObject;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Roave\DeveloperTools\Stub\SerializableValueStub;
use stdClass;
use Traversable;
use Zend\Stdlib\ArrayUtils;

/**
 * Tests for {@see \Roave\DeveloperTools\Stub\SerializableValueStub}
 *
 * @covers \Roave\DeveloperTools\Stub\SerializableValueStub
 */
class SerializableValueStubTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $value
     *
     * @dataProvider getCheckedValues
     */
    public function testStoredValueIsCorrect($value)
    {
        $this->assertSuperficiallyEquals($value, (new SerializableValueStub($value))->getValue());
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getCheckedValues
     */
    public function testStoredValueIsCorrectlySerialized($value)
    {
        $this->assertSuperficiallyEquals(
            $value,
            unserialize(serialize((new SerializableValueStub($value))))->getValue()
        );
    }

    /**
     * @param mixed $expected
     * @param mixed $value
     *
     * @dataProvider getCheckedValues
     */
    private function assertSuperficiallyEquals($expected, $value)
    {
        if ($value instanceof Traversable || $expected instanceof Traversable) {
            $this->assertSuperficiallyEquals(
                ArrayUtils::iteratorToArray($expected),
                ArrayUtils::iteratorToArray($value)
            );

            return;
        }

        if (is_array($expected)) {
            foreach ($expected as $key => $expectedVal) {
                $this->assertSuperficiallyEquals($expectedVal, $value[$key]);
            }

            return;
        }

        if (is_object($expected)) {
            if ($expected instanceof \Closure) {
                // note: HHVM stores closure class names with their own name that is relative to the declaration scope
                $this->assertInstanceOf('Closure', $value);
            } else {
                $this->assertSame(get_class($expected), get_class($value));
            }

            return;
        }

        $this->assertSame($expected, $value);
    }

    /**
     * Data provider
     *
     * @return mixed[][]
     */
    public function getCheckedValues()
    {
        return [
            [function () {
            }],
            ['a'],
            [['a', 'b']],
            [['a' => 'b', 'b' => 'c']],
            [['a' => 'b', 'b']],
            [new ArrayObject(['a' => 'b', 'b'])],
            [new ArrayObject(['a' => 'b', new stdClass()])],
            [new ArrayObject([
                'a' => 'b',
                function () {
                },
            ])],
            [new stdClass()],
            [null],
            [new ReflectionClass($this)],
        ];
    }
}
