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

namespace RoaveTest\DeveloperTools\Renderer\ToolbarTab;

use Roave\DeveloperTools\Inspection\AggregateInspection;
use Roave\DeveloperTools\Inspection\ExceptionInspection;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Inspection\TimeInspection;
use Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarExceptionRenderer;
use RoaveTest\DeveloperTools\Renderer\BaseInspectionRendererTest;

/**
 * Tests for {@see \Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarExceptionRenderer}
 *
 * @covers \Roave\DeveloperTools\Renderer\ToolbarTab\ToolbarExceptionRenderer
 */
class ToolbarExceptionRendererTest extends BaseInspectionRendererTest
{
    /**
     * {@inheritDoc}
     */
    public function getRenderer()
    {
        return new ToolbarExceptionRenderer();
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportedInspections()
    {
        return [[$this->getMock(ExceptionInspection::class, [], [], '', false)]];
    }

    /**
     * {@inheritDoc}
     */
    public function getUnSupportedInspections()
    {
        return [
            [$this->getMock(InspectionInterface::class)],
            [$this->getMock(TimeInspection::class, [], [], '', false)],
            [$this->getMock(AggregateInspection::class, [], [], '', false)],
        ];
    }
}
