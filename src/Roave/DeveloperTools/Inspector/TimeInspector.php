<?php
/**
 * Created by PhpStorm.
 * User: ocramius
 * Date: 17/04/14
 * Time: 04:28
 */

namespace Roave\DeveloperTools\Inspector;


use Roave\DeveloperTools\Inspection\TimeInspection;
use Zend\EventManager\EventInterface;

class TimeInspector implements InspectorInterface
{
    /**
     * @var array of inspection times indexed by event spl_object_hash
     */
    private $inspections = [];

    public function reset(EventInterface $event)
    {
        $microtime = microtime(true);

        $this->inspections[spl_object_hash($event)] = [$microtime, $microtime];
    }

    /**
     * {@inheritDoc}
     */
    public function inspect(EventInterface $event)
    {
        $microtime = microtime(true);
        $oid       = spl_object_hash($event);

        if (! isset($this->inspections[$oid])) {
            $this->inspections[$oid] = [$microtime, $microtime];
        }

        $this->inspections[$oid][1] = $microtime;

        return new TimeInspection($this->inspections[$oid][0], $this->inspections[$oid][1]);
    }
}
