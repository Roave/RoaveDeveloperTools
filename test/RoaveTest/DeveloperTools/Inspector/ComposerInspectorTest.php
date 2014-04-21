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

namespace RoaveTest\DeveloperTools\Inspector;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Inspection\ComposerInspection;
use Roave\DeveloperTools\Inspector\ComposerInspector;
use Zend\EventManager\EventInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Inspector\ComposerInspector}
 *
 * @covers \Roave\DeveloperTools\Inspector\ComposerInspector
 */
class ComposerInspectorTest extends PHPUnit_Framework_TestCase
{
    public function testCanDetectComposer()
    {
        $inspector = new ComposerInspector();

        $inspection = $inspector->inspect($this->getMock(EventInterface::class));

        $this->assertInstanceOf(ComposerInspection::class, $inspection);

        $data = $inspection->getInspectionData();

        $this->assertNotEmpty($data[ComposerInspection::PARAM_COMPOSER_JSON]);
        $this->assertNotEmpty($data[ComposerInspection::PARAM_COMPOSER_LOCK]);
        $this->assertNotEmpty($data[ComposerInspection::PARAM_COMPOSER_INSTALLED]);

        $this->assertNotSame(
            $data[ComposerInspection::PARAM_COMPOSER_JSON],
            $data[ComposerInspection::PARAM_COMPOSER_LOCK]
        );
        $this->assertNotSame(
            $data[ComposerInspection::PARAM_COMPOSER_JSON],
            $data[ComposerInspection::PARAM_COMPOSER_INSTALLED]
        );
        $this->assertNotSame(
            $data[ComposerInspection::PARAM_COMPOSER_LOCK],
            $data[ComposerInspection::PARAM_COMPOSER_INSTALLED]
        );
    }
}
