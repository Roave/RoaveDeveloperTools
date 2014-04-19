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

namespace Roave\DeveloperTools\Inspection;

use Exception;

/**
 * Inspection used to record an exception
 */
class ExceptionInspection implements InspectionInterface
{
    /**
     * @var array[]
     */
    private $exceptions;

    /**
     * @param Exception $exception
     */
    public function __construct(Exception $exception)
    {
        $this->exceptions = $this->cleanExceptions($exception);
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->exceptions);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->exceptions = unserialize($serialized);
    }

    /**
     * {@inheritDoc}
     */
    public function getInspectionData()
    {
        return $this->exceptions;
    }

    /**
     * @param Exception $exception
     *
     * @return array a serializable version of the exception
     */
    private function cleanExceptions(Exception $exception)
    {
        $exceptions = [];

        do {
            $exceptions[] = [
                'class'         => get_class($exception),
                'message'       => $exception->getMessage(),
                'code'          => $exception->getCode(),
                'file'          => $exception->getFile(),
                'line'          => $exception->getLine(),
                'traceAsString' => $exception->getTraceAsString(),
                'trace'         => $this->cleanTrace($exception),
            ];
        } while ($exception = $exception->getPrevious());

        return $exceptions;
    }

    /**
     * @param Exception $exception
     *
     * @return array a serializable version of the exception stack trace
     */
    private function cleanTrace(Exception $exception)
    {
        return array_map(
            function (array $traceItem) {
                return [
                    'file'     => isset($traceItem['file']) ? $traceItem['file'] : null,
                    'function' => $traceItem['function'],
                    'class'    => isset($traceItem['class']) ? $traceItem['class'] : null,
                    'object'   => isset($traceItem['object']) ? get_class($traceItem['object']) : null,
                    'type'     => $traceItem['type'],
                    'args'     => $this->cleanArgs($traceItem['args']),
                ];
            },
            $exception->getTrace()
        );
    }

    /**
     * @param mixed[] $arguments
     *
     * @return array a serializable version of the provided stack arguments
     */
    private function cleanArgs($arguments)
    {
        return array_map(
            function ($argument) {
                if (is_array($argument)) {
                    return ['type' => 'array'];
                }

                if (is_scalar($argument)) {
                    return [
                        'type'  => gettype($argument),
                        'value' => $argument,
                    ];
                }

                if (is_object($argument)) {
                    return ['type'  => get_class($argument)];
                }

                if (is_resource($argument)) {
                    return ['type'  => 'resource'];
                }

                return [];
            },
            $arguments
        );
    }
}
