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

namespace Roave\DeveloperTools\Renderer\ToolbarTab;

use Roave\DeveloperTools\Inspection\AggregateInspection;
use Roave\DeveloperTools\Inspection\EventInspection;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Renderer\BaseInspectionRenderer;

/**
 * Renders a group of given events
 */
class ToolbarEventsRenderer extends BaseInspectionRenderer
{
    /**
     * {@inheritDoc}
     */
    protected $supportedInspection = AggregateInspection::class;

    /**
     * {@inheritDoc}
     */
    protected $templateName = 'roave-developer-tools/toolbar/tab/events';

    /**
     * {@inheritDoc}
     */
    public function canRender(InspectionInterface $inspection)
    {
        // all values in the AggregateInspection are EventInspection, and the aggregate inspection is not empty
        return parent::canRender($inspection)
            && array_filter(array_map(
                function (InspectionInterface $inspection) {
                    return $inspection instanceof EventInspection;
                },
                $inspection->getInspectionData()
            ));
    }
}
