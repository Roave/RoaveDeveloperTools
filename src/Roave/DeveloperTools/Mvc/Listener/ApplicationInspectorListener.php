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

namespace Roave\DeveloperTools\Mvc\Listener;

use Roave\DeveloperTools\Inspector\InspectorInterface;
use Roave\DeveloperTools\Repository\InspectionRepositoryInterface;
use Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;

/**
 * Application inspector listener to be attached to a {@see \Zend\Mvc\Application}'s
 * {@see \Zend\EventManager\EventManagerInterface}
 *
 * Listens to the event {@see \Zend\Mvc\MvcEvent::EVENT_FINISH} and iterates over
 * collectors to produce an aggregate inspection
 */
class ApplicationInspectorListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    const PRIORITY = -9999999;

    /**
     * @var InspectionRepositoryInterface
     */
    private $inspectionRepository;

    /**
     * @var \Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface
     */
    private $uuidGenerator;

    /**
     * @var \Roave\DeveloperTools\Inspector\InspectorInterface
     */
    private $inspector;

    /**
     * @param InspectionRepositoryInterface $inspectionRepository
     * @param UUIDGeneratorInterface        $uuidGenerator
     * @param InspectorInterface            $inspector
     */
    public function __construct(
        InspectionRepositoryInterface $inspectionRepository,
        UUIDGeneratorInterface $uuidGenerator,
        InspectorInterface $inspector
    ) {
        $this->inspectionRepository = $inspectionRepository;
        $this->uuidGenerator        = $uuidGenerator;
        $this->inspector            = $inspector;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_FINISH,
            [$this, 'collectInspectionsOnApplicationFinish'],
            static::PRIORITY
        );
    }

    /**
     * Collects and persists the current inspection results
     *
     * @param EventInterface $event
     *
     * @return string
     */
    public function collectInspectionsOnApplicationFinish(EventInterface $event)
    {
        $inspection = $this->inspector->inspect($event);
        $uuid       = $this->uuidGenerator->generateUUID();

        $this->inspectionRepository->add($uuid, $inspection);

        return $uuid;

        // @todo should:
        //   (4) trigger logic that renders eventual RoaveDeveloperTools UI elements on the response
    }
}
