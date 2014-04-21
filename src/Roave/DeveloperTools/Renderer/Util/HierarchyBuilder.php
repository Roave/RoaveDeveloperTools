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

namespace Roave\DeveloperTools\Renderer\Util;

/**
 * Utility class to build hierarchies out of flat array structures of index references
 */
class HierarchyBuilder
{
    /**
     * Produces a hierarchy structure from a given flat identifier map, like in following example:
     *
     * [
     *   'parent' => null,
     *   'child1' => 'parent',
     *   'child2' => 'child1',
     * ]
     *
     * Becomes
     *
     * [
     *   'parent' => [
     *     'child1' => [
     *       'child2' => [],
     *     ],
     *   ],
     * ]
     *
     * @param  array $map
     * @return array
     */
    public function fromIdentifiersMap(array $map)
    {
        $childrenMap = $this->getChildrenMap($map);

        $indexed = [];

        foreach (array_keys($map) as $key) {
            if (empty($map[$key])) {
                $indexed[$key] = $this->explodeChildren($key, $childrenMap);
            }
        }

        return $indexed;
    }

    /**
     * Reverses an inheritance map $childrenId => $parents like following:
     *
     * [
     *   'parent' => [],
     *   'child1'  => ['parent'],
     *   'child2'  => ['child1'],
     * ]
     *
     * Becomes
     *
     * [
     *   'parent' => ['child1'],
     *   'child1' => ['child2'],
     *   'child2' => [],
     * ]
     *
     * @param  array $parentsMap
     * @return array
     */
    public function getChildrenMap(array $parentsMap)
    {
        // fill $rootParents with empty arrays
        $rootParents = array_map(
            function () {
                return [];
            },
            array_flip(array_keys($parentsMap))
        );

        foreach ($parentsMap as $childId => $parentId) {
            if (null !== $parentId) {
                $rootParents[$parentId][] = $childId;
            }
        }

        return $rootParents;
    }

    /**
     * Retrieves all children of a given element, recursively
     * Must be given a childrenMap for performance reasons
     *
     * @param string $id
     * @param array  $childrenMap
     *
     * @return array
     */
    private function explodeChildren($id, array $childrenMap)
    {
        if (! isset($childrenMap[$id])) {
            return [];
        }

        // Indexing items by their value
        $indexed = [];

        foreach ($childrenMap[$id] as $childName) {
            $indexed[$childName] = $childName;
        }

        return array_map(
            function ($childId) use ($childrenMap) {
                return $this->explodeChildren($childId, $childrenMap);
            },
            $indexed
        );
    }
}
