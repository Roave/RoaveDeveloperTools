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

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Renderer\Util\HierarchyBuilder;
use Roave\DeveloperTools\Renderer\Util\TraceComparator;

/**
 * Tests for {@see \Roave\DeveloperTools\Renderer\Util\TraceComparator}
 *
 * @covers \Roave\DeveloperTools\Renderer\Util\TraceComparator
 */
class TraceComparatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $childTrace
     * @param array $parentTrace
     * @param bool  $expected
     *
     * @dataProvider getComparedTraces
     */
    public function testIsChildTrace(array $childTrace, array $parentTrace, $expected)
    {
        $this->assertSame($expected, (new TraceComparator())->isChildTrace($childTrace, $parentTrace));
    }

    public function getComparedTraces()
    {
        $realTrace    = debug_backtrace();
        $invalidChild = array_slice($realTrace, 0, count($realTrace) - 1);
        $validChild   = array_slice($realTrace, 1, count($realTrace) - 1);

        return [
            [[], [], false],
            [[[]], [], true],
            [$realTrace, $invalidChild, false],
            [$realTrace, $validChild, true],
            [$realTrace, $realTrace, false],
            [
                [
                    [
                        'file'     => 'filename.php',
                        'line'     => 123,
                        'function' => 'foo',
                    ],
                    [
                        'file'     => 'filename2.php',
                        'line'     => 456,
                        'function' => 'bar',
                    ],
                ],
                [
                    [
                        'file'     => 'filename.php',
                        'line'     => 123,
                        'function' => 'foo',
                    ],
                ],
                true
            ]
        ];
    }
}
