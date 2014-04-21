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

use Closure;

/**
 * Utility to compare stack traces
 */
class TraceComparator
{
    /**
     * @param array $childTrace
     * @param array $parentTrace
     *
     * @return bool
     */
    public function isChildTrace(array $childTrace, array $parentTrace)
    {
        $childTraceLength  = count($childTrace);
        $parentTraceLength = count($parentTrace);

        if ($childTraceLength <= $parentTraceLength) {
            return false;
        }

        for ($pointer = 1; ($parentTraceLength - $pointer) > 0; $pointer += 1) {
            $parentTraceFrame = $parentTrace[$parentTraceLength - $pointer];
            $childTraceFrame  = $childTrace[$childTraceLength - $pointer];

            if ($parentTraceFrame['file'] !== $childTraceFrame['file']
                || $parentTraceFrame['line'] !== $childTraceFrame['line']
                || $parentTraceFrame['function'] !== $childTraceFrame['function']
                || ! $this->sameType($parentTraceFrame, $childTraceFrame)
                || ! $this->sameClass($parentTraceFrame, $childTraceFrame)
                || $this->getClass($parentTraceFrame) !== $this->getClass($childTraceFrame)
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $traceFrame1
     * @param array $traceFrame2
     *
     * @return bool
     */
    private function sameType(array $traceFrame1, array $traceFrame2)
    {
        $type1 = isset($traceFrame1['type']) ? $traceFrame1['type'] : null;
        $type2 = isset($traceFrame2['type']) ? $traceFrame2['type'] : null;

        return $type1 === $type2;
    }

    /**
     * @param array $traceFrame1
     * @param array $traceFrame2
     *
     * @return bool
     */
    private function sameClass(array $traceFrame1, array $traceFrame2)
    {
        $class1 = isset($traceFrame1['class']) ? $traceFrame1['class'] : null;
        $class2 = isset($traceFrame2['class']) ? $traceFrame2['class'] : null;

        return $class1 === $class2;
    }

    /**
     * @param array $traceFrame
     * @return null|string
     */
    private function getClass(array $traceFrame)
    {
        if (isset($traceFrame['object'])) {
            if ($traceFrame['object'] instanceof Closure) {
                return 'Closure';
            }

            return get_class($traceFrame['object']);
        }

        return null;
    }
}
