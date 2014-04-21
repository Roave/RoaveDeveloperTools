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

namespace RoaveTest\DeveloperTools\Mvc\Inspection;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Mvc\Configuration\RoaveDeveloperToolsConfiguration;
use Zend\Stdlib\Exception\BadMethodCallException;

/**
 * Tests for {@see \Roave\DeveloperTools\Mvc\Configuration\RoaveDeveloperToolsConfiguration}
 *
 * @covers \Roave\DeveloperTools\Mvc\Configuration\RoaveDeveloperToolsConfiguration
 */
class RoaveDeveloperToolsConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function testConfigurationIsStrict()
    {
        $this->setExpectedException(BadMethodCallException::class);

        new RoaveDeveloperToolsConfiguration(['non_existing' => 'value']);
    }

    public function testGetSetInspectors()
    {
        $config = new RoaveDeveloperToolsConfiguration(['inspectors' => [
            'foo',
            'bar',
            'baz',
        ]]);

        $this->assertSame(['foo', 'bar', 'baz'], $config->getInspectors());
    }

    public function testGetSetInspectionPersistenceDir()
    {
        $config = new RoaveDeveloperToolsConfiguration(['inspections_persistence_dir' => 'foobar']);

        $this->assertSame('foobar', $config->getInspectionsPersistenceDir());
    }

    public function testGetSetToolbarTabRenderers()
    {
        $config = new RoaveDeveloperToolsConfiguration(['toolbar_tab_renderers' => [
            'foo',
            'bar',
            'baz',
        ]]);

        $this->assertSame(['foo', 'bar', 'baz'], $config->getToolbarTabRenderers());
    }

    public function testGetSetDetailRenderers()
    {
        $config = new RoaveDeveloperToolsConfiguration(['detail_renderers' => [
            'foo',
            'bar',
            'baz',
        ]]);

        $this->assertSame(['foo', 'bar', 'baz'], $config->getDetailRenderers());
    }
}
