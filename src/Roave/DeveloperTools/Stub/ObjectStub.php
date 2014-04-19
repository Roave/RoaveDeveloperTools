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

namespace Roave\DeveloperTools\Stub;

use Closure;
use ReflectionClass;
use Roave\DeveloperTools\Stub\Exception\InvalidArgumentException;
use Serializable;

/**
 * Simple placeholder to be used in place of closures when serializing data
 */
class ObjectStub implements Serializable
{
    private $className;

    /**
     * @param object $value
     *
     * @throws InvalidArgumentException
     */
    public function __construct($value)
    {
        if (! is_object($value)) {
            throw InvalidArgumentException::notAnObject($value);
        }

        $this->className = get_class($value);
    }

    /**
     * @return object
     */
    public function getObject()
    {
        if (Closure::class === $this->className) {
            return function () {
            };
        }

        return (new ReflectionClass($this->className))->newInstanceWithoutConstructor();
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->className);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->className = unserialize($serialized);
    }
}
