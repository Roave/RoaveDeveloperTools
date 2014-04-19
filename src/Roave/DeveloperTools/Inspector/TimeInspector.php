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

namespace Roave\DeveloperTools\Inspector;


use Roave\DeveloperTools\Inspection\TimeInspection;
use Zend\EventManager\EventInterface;

/**
 * Inspector that captures times for a given event
 */
class TimeInspector implements InspectorInterface
{
    /**
     * @var array of inspection times indexed by event spl_object_hash
     *
     * @todo this may lead to memory leaks - inspections should probably be cleared on a call to `inspect`
     * @todo need a base inspector that stores data per-event
     */
    private $inspections = [];

    /**
     * @param EventInterface $event
     */
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
