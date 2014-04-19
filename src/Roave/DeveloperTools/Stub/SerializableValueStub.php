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

use Serializable;
use Traversable;
use Zend\Stdlib\ArrayUtils;

/**
 * Placeholder value that holds an arbitrary value, which may or may not be
 * serializable.
 *
 * Objects are replaced in the serialized version with stub counterparts, as well
 * as closures
 *
 * MAKE ALL ZE THINGS SERIALIZABLE!
 */
class SerializableValueStub implements Serializable
{
    /**
     * @var mixed (serializable)
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $this->makeSerializable($value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->makeReal($this->value);
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->value);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->value = unserialize($serialized);
    }

    /**
     * Retrieves a serializable version of a given value
     *
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws \Zend\Stdlib\Exception\InvalidArgumentException
     */
    private function makeSerializable($value)
    {
        if (null === $value) {
            return $value;
        }

        if ($value instanceof Traversable || is_array($value)) {
            $value = ArrayUtils::iteratorToArray($value);

            foreach ($value as $key => $val) {
                $value[$key] = $this->makeSerializable($val);
            }

            return $value;
        }

        if (is_scalar($value)) {
            return $value;
        }

        if (is_resource($value)) {
            return 'resource';
        }

        return new ObjectStub($value);
    }

    /**
     * Retrieves a "semi-real" version of the value
     *
     * @param mixed $value
     *
     * @return mixed
     */
    private function makeReal($value)
    {
        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = $this->makeReal($val);
            }
        }

        if ($value instanceof ObjectStub) {
            return $value->getObject();
        }

        return $value;
    }
}
