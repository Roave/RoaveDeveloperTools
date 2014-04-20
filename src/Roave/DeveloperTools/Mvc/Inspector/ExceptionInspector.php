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

namespace Roave\DeveloperTools\Mvc\Inspector;

use Exception;
use Roave\DeveloperTools\Inspection\ExceptionInspection;
use Roave\DeveloperTools\Inspection\NullInspection;
use Roave\DeveloperTools\Inspector\InspectorInterface;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;

/**
 * Inspector that produces an {@see \Roave\DeveloperTools\Inspection\ExceptionInspection} if
 * the application has an exception, or an {@see \Roave\DeveloperTools\Inspection\NullInspection} if no
 * exception had been provided
 */
class ExceptionInspector implements InspectorInterface
{
    /**
     * {@inheritDoc}
     */
    public function inspect(EventInterface $event)
    {
        if (! $event instanceof MvcEvent) {
            return new NullInspection();
        }

        $exception = $event->getParam('exception');

        if (! $exception instanceof Exception) {
            return new NullInspection();
        }

        return new ExceptionInspection($exception);
    }
}
