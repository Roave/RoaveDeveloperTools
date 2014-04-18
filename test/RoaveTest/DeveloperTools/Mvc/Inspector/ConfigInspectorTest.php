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

namespace RoaveTest\DeveloperTools\Mvc\Inspector;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Mvc\Inspection\ConfigInspection;
use Roave\DeveloperTools\Mvc\Inspector\ConfigInspector;
use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Inspector\ConfigInspector}
 *
 * @covers \Roave\DeveloperTools\Mvc\Inspector\ConfigInspector
 */
class ConfigInspectorTest extends PHPUnit_Framework_TestCase
{
    public function testInspect()
    {
        $locator   = $this->getMock(ServiceLocatorInterface::class);
        $inspector = new ConfigInspector($locator, 'foo');

        $locator->expects($this->any())->method('get')->with('foo')->will($this->returnValue(['a' => 'b']));

        $inspection = $inspector->inspect($this->getMock(EventInterface::class));

        $this->assertInstanceOf(ConfigInspection::class, $inspection);
        $this->assertSame(['a' => 'b'], $inspection->getInspectionData());
    }
}
