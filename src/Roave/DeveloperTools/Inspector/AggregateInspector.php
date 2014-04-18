<?php
/**
 * Created by PhpStorm.
 * User: ocramius
 * Date: 17/04/14
 * Time: 04:28
 */

namespace Roave\DeveloperTools\Inspector;

use Roave\DeveloperTools\Inspection\AggregateInspection;
use Zend\EventManager\EventInterface;

/**
 * Aggregate inspector - aggregates the results of multiple inspectors into a single aggregate inspection
 */
class AggregateInspector implements InspectorInterface
{
    /**
     * @var InspectorInterface[]
     */
    private $inspectors;

    /**
     * @param InspectorInterface[] $inspectors
     */
    public function __construct($inspectors)
    {
        $this->inspectors = array_values(array_map(
            function (InspectorInterface $inspector) {
                return $inspector;
            },
            $inspectors
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function inspect(EventInterface $event)
    {
        return new AggregateInspection(array_map(
            function (InspectorInterface $inspector) use ($event) {
                return $inspector->inspect($event);
            },
            $this->inspectors
        ));
    }
}
