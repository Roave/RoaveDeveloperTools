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

namespace Roave\DeveloperTools\Mvc\Inspection;

use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Stub\ObjectStub;
use Zend\Stdlib\ArrayUtils;

/**
 * An inspection that contains a configuration array/traversable
 */
class ConfigInspection implements InspectionInterface
{
    /**
     * @var mixed[]
     */
    private $config;

    /**
     * @param mixed[] $config
     */
    public function __construct($config)
    {
        $this->config = ArrayUtils::iteratorToArray($config);
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->makeArraySerializable($this->config));
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->config = $this->unserializeArray(unserialize($serialized));
    }

    /**
     * {@inheritDoc}
     */
    public function getInspectionData()
    {
        return $this->config;
    }

    /**
     * Replaces the un-serializable items in an array with stubs
     *
     * @param array|\Traversable $data
     *
     * @return array
     */
    private function makeArraySerializable(array $data)
    {
        $serializable = [];

        foreach ($data as $key => $value) {
            if (is_object($value)) {
                $serializable[$key] = new ObjectStub($value);

                continue;
            }

            $serializable[$key] = is_array($value) ? $this->makeArraySerializable($value) : $value;
        }

        return $serializable;
    }

    /**
     * Opposite of {@see makeArraySerializable} - replaces stubs in an array with actual un-serializable objects
     *
     * @param array $data
     *
     * @return array
     */
    private function unserializeArray(array $data)
    {
        $unserialized = [];

        foreach ($data as $key => $value) {
            if ($value instanceof ObjectStub) {
                $unserialized[$key] = $value->getObject();

                continue;
            }

            $unserialized[$key] = is_array($value) ? $this->unserializeArray($value) : $value;
        }

        return $unserialized;
    }
}
