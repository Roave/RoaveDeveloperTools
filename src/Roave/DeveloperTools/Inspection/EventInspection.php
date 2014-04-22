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

use Roave\DeveloperTools\Stub\ObjectStub;
use Roave\DeveloperTools\Stub\SerializableValueStub;
use Zend\EventManager\EventInterface;

/**
 * An inspection that contains data about an {@see \Zend\EventManager\EventInterface}
 */
class EventInspection implements InspectionInterface
{
    const PARAM_TIME                   = 'time';
    const PARAM_MEMORY                 = 'memory';
    const PARAM_EVENT_ID               = 'eventId';
    const PARAM_IS_START               = 'isStart';
    const PARAM_NAME                   = 'name';
    const PARAM_EVENT                  = 'event';
    const PARAM_TARGET                 = 'target';
    const PARAM_PARAMS                 = 'params';
    const PARAM_PROPAGATION_IS_STOPPED = 'propagationIsStopped';
    const PARAM_TRACE                  = 'trace';

    /**
     * @var float
     */
    private $time;

    /**
     * @var int
     */
    private $memory;

    /**
     * @var string
     */
    private $eventId;

    /**
     * @var bool
     */
    private $isStart;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ObjectStub
     */
    private $event;

    /**
     * @var SerializableValueStub
     */
    private $target;

    /**
     * @var SerializableValueStub
     */
    private $params;

    /**
     * @var bool
     */
    private $propagationIsStopped;

    /**
     * @var SerializableValueStub
     */
    private $trace;

    /**
     * @param string         $eventId
     * @param bool           $isStart
     * @param EventInterface $event
     * @param array          $trace
     */
    public function __construct(
        $eventId,
        $isStart,
        EventInterface $event,
        array $trace
    ) {
        $this->time                 = microtime(true);
        $this->memory               = memory_get_usage();
        $this->eventId              = (string) $eventId;
        $this->isStart              = (bool) $isStart;
        $this->event                = new ObjectStub($event);
        $this->name                 = $event->getName();
        $this->target               = new SerializableValueStub($event->getTarget());
        $this->params               = new SerializableValueStub($event->getParams());
        $this->propagationIsStopped = (bool) $event->propagationIsStopped();
        // @todo serializing/converting this data is VERY performance-intensive, and it shouldn't be done all the time
        $this->trace                = new SerializableValueStub($trace);
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize(get_object_vars($this));
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        foreach (unserialize($serialized) as $var => $val) {
            $this->$var = $val;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function getInspectionData()
    {
        return [
            static::PARAM_TIME                   => $this->time,
            static::PARAM_MEMORY                 => $this->memory,
            static::PARAM_EVENT_ID               => $this->eventId,
            static::PARAM_IS_START               => $this->isStart,
            static::PARAM_EVENT                  => $this->event->getObject(),
            static::PARAM_NAME                   => $this->name,
            static::PARAM_TARGET                 => $this->target->getValue(),
            static::PARAM_PARAMS                 => $this->params->getValue(),
            static::PARAM_PROPAGATION_IS_STOPPED => $this->propagationIsStopped,
            static::PARAM_TRACE                  => $this->trace->getValue(),
        ];
    }
}
