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
     * @var
     */
    private $inspections = [];

    public function reset(EventInterface $event)
    {
        // TODO: Implement reset() method.
    }

    /**
     * {@inheritDoc}
     */
    public function inspect(EventInterface $event)
    {
        return new TimeInspection();
    }
}