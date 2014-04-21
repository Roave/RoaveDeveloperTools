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

/**
 * Tests for {@see \Roave\DeveloperTools\Renderer\Util\HierarchyBuilder}
 *
 * @covers \Roave\DeveloperTools\Renderer\Util\HierarchyBuilder
 */
class HierarchyBuilderTest extends PHPUnit_Framework_TestCase
{
    public function testFromIdentifierMapWithoutRelations()
    {
        $flatMap = [
            'id1' => [],
            'id2' => [],
            'id3' => [],
        ];

        $this->assertEquals($flatMap, (new HierarchyBuilder())->fromIdentifiersMap($flatMap));
    }

    public function testFromIdentifierMapWithSimpleRelations()
    {
        $flatMap = [
            'id1' => [],
            'id2' => ['id1'],
            'id3' => ['id2'],
        ];

        $this->assertEquals(
            [
                'id1' => [
                    'id2' => [
                        'id3' => [],
                    ],
                ],
            ],
            (new HierarchyBuilder())->fromIdentifiersMap($flatMap)
        );
    }

    public function testGetChildrenMapWithEmptyInheritance()
    {
        $flatMap = [
            'id1' => [],
            'id2' => [],
            'id3' => [],
        ];

        $this->assertEquals($flatMap, (new HierarchyBuilder())->getChildrenMap($flatMap));
    }

    public function testGetChildrenMapWithSimpleRelations()
    {
        $flatMap = [
            'id1' => [],
            'id2' => ['id1'],
            'id3' => ['id2'],
        ];

        $this->assertEquals(
            [
                'id1' => ['id2'],
                'id2' => ['id3'],
                'id3' => [],
            ],
            (new HierarchyBuilder())->getChildrenMap($flatMap)
        );
    }

    public function testExplodeChildrenMapWithEmptyInheritance()
    {
        $childrenMap = [
            'id1' => [],
            'id2' => [],
            'id3' => [],
        ];

        $method = new \ReflectionMethod(HierarchyBuilder::class, 'explodeChildren');

        $method->setAccessible(true);

        $this->assertEquals([], $method->invoke(new HierarchyBuilder(), 'id1', $childrenMap));
        $this->assertEquals([], $method->invoke(new HierarchyBuilder(), 'id2', $childrenMap));
        $this->assertEquals([], $method->invoke(new HierarchyBuilder(), 'id3', $childrenMap));
    }

    public function testExplodeChildrenMapWithSimpleRelations()
    {
        $childrenMap = [
            'id1' => ['id2'],
            'id2' => ['id3'],
            'id3' => [],
        ];

        $method = new \ReflectionMethod(HierarchyBuilder::class, 'explodeChildren');

        $method->setAccessible(true);

        $this->assertEquals([], $method->invoke(new HierarchyBuilder(), 'id3', $childrenMap));
        $this->assertEquals(['id3' => []], $method->invoke(new HierarchyBuilder(), 'id2', $childrenMap));
        $this->assertEquals(['id2' => ['id3' => []]], $method->invoke(new HierarchyBuilder(), 'id1', $childrenMap));
    }
}
