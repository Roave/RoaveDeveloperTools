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

namespace RoaveTest\DeveloperTools\Repository\UUIDGenerator;

use PHPUnit_Framework_TestCase;

/**
 * Base tests for {@see \Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface}
 *
 * @covers \Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface
 */
abstract class AbstractUUIDGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return \Roave\DeveloperTools\Repository\UUIDGenerator\UUIDGeneratorInterface
     */
    protected abstract function getUUIDGenerator();

    public function testGeneratedUUIDIsString()
    {
        $this->assertInternalType('string', $this->getUUIDGenerator()->generateUUID());
    }

    public function testGeneratedUUIDIsUnique()
    {
        $generator = $this->getUUIDGenerator();

        $this->assertNotEquals($generator->generateUUID(), $generator->generateUUID());
    }
}
