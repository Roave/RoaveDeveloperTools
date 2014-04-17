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

namespace Roave\DeveloperTools\Mvc;

use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * Application inspector listener to be attached to a {@see \Zend\Mvc\Application}'s
 * {@see \Zend\EventManager\EventManagerInterface}
 *
 * Listens to the event {@see \Zend\Mvc\MvcEvent::EVENT_FINISH} and iterates over
 * collectors to produce an aggregate inspection
 */
class ApplicationInspectorListener extends AbstractListenerAggregate
{
    /**
     * @var \Roave\DeveloperTools\Inspection\InspectionInterface|null
     *
     * @todo this should be different per-event.
     * @todo this may cause memleaks. As of the {@see \Roave\DeveloperTools\Inspector\TimeInspector}, inspections
     *       should be removed after usage
     */
    private $currentInspection;

    /**
     * @var InspectionRepositoryInterface
     */
    private $inspectionRepository;

    /**
     * @param InspectionRepositoryInterface $inspectionRepository
     */
    public function __construct(InspectionRepositoryInterface $inspectionRepository)
    {
        $this->inspectionRepository = $inspectionRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach([$this]);
    }

    public function collectInspectionsOnApplicationFinish(EventInterface $event)
    {
        // @todo implement

        // @todo should:
        //   (1) fetch all inspectors
        //   (2) trigger the `collect` on each inspector (step 1 and 2 could be handled by an "Aggregate Inspector")
        //   (3) produce an aggregate inspection
        //   (4) produce an UUID for the inspection
        //   (5) save the inspection
        //   (6) trigger logic that renders eventual RoaveDeveloperTools UI elements on the response
    }
}
