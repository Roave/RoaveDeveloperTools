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

namespace RoaveTest\DeveloperTools\Inspection;

use Roave\DeveloperTools\Inspection\DeclaredSymbolsInspection;
use Roave\DeveloperTools\Inspection\TimeInspection;

/**
 * Tests for {@see \Roave\DeveloperTools\Inspection\DeclaredSymbolsInspection}
 *
 * @covers \Roave\DeveloperTools\Inspection\DeclaredSymbolsInspection
 */
class DeclaredSymbolsInspectionTest extends AbstractInspectionTest
{
    /**
     * {@inheritDoc}
     */
    protected function getInspection()
    {
        return new DeclaredSymbolsInspection();
    }

    public function testGetDeclaredClasses()
    {
        $className = 'testClass' . uniqid();

        eval('namespace ' . __NAMESPACE__ . '; class ' . $className . ' {}');

        $classes = $this->getInspection()->getInspectionData()[DeclaredSymbolsInspection::PARAM_CLASSES];

        $this->assertInternalType('array', $classes);
        $this->assertTrue(in_array(__NAMESPACE__ . '\\' . $className, $classes, true));
    }

    public function testGetDeclaredInterfaces()
    {
        $interfaceName = 'testInterface' . uniqid();

        eval('namespace ' . __NAMESPACE__ . '; interface ' . $interfaceName . ' {}');

        $interfaces = $this->getInspection()->getInspectionData()[DeclaredSymbolsInspection::PARAM_INTERFACES];

        $this->assertInternalType('array', $interfaces);
        $this->assertTrue(in_array(__NAMESPACE__ . '\\' . $interfaceName, $interfaces, true));
    }

    public function testGetDeclaredTraits()
    {
        $traitName = 'testTrait' . uniqid();

        eval('namespace ' . __NAMESPACE__ . '; trait ' . $traitName . ' {}');

        $traits = $this->getInspection()->getInspectionData()[DeclaredSymbolsInspection::PARAM_TRAITS];

        $this->assertInternalType('array', $traits);
        $this->assertTrue(in_array(__NAMESPACE__ . '\\' . $traitName, $traits, true));
    }

    public function testGetDeclaredFunctions()
    {
        $functionName = 'testFunction' . uniqid();

        eval('namespace ' . __NAMESPACE__ . '; function ' . $functionName . '() {}');

        $functions = $this->getInspection()->getInspectionData()[DeclaredSymbolsInspection::PARAM_FUNCTIONS];

        $this->assertInternalType('array', $functions);
        $this->assertTrue(in_array(strtolower(__NAMESPACE__ . '\\' . $functionName), $functions, true));
    }

    public function testGetDeclaredConstants()
    {
        $constantName = 'testConstant' . uniqid();

        define($constantName, __CLASS__);

        $constants = $this->getInspection()->getInspectionData()[DeclaredSymbolsInspection::PARAM_CONSTANTS];

        $this->assertInternalType('array', $constants);
        $this->assertTrue(in_array($constantName, $constants, true));
    }
}
