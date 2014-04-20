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

use BadMethodCallException;
use InvalidArgumentException;
use Roave\DeveloperTools\Inspection\ExceptionInspection;

/**
 * Tests for {@see \Roave\DeveloperTools\Inspection\ExceptionInspection}
 *
 * @covers \Roave\DeveloperTools\Inspection\ExceptionInspection
 */
class ExceptionInspectionTest extends AbstractInspectionTest
{
    public function testSimpleException()
    {
        $inspectionData = $this->getInspection()->getInspectionData();

        $this->assertCount(1, $inspectionData);
        $this->assertSame(__FILE__, $inspectionData[0]['file']);
        $this->assertSame('InvalidArgumentException', $inspectionData[0]['class']);
        $this->assertSame(__CLASS__, $inspectionData[0]['trace'][0]['class']);

        $this->assertGreaterThan(1, count($inspectionData[0]['trace']));
    }

    public function testExceptionWithPrevious()
    {
        $inspection = new ExceptionInspection(new InvalidArgumentException('foo', 123, new BadMethodCallException()));

        $this->assertCount(2, $inspection->getInspectionData());
    }

    /**
     * {@inheritDoc}
     */
    protected function getInspection()
    {
        return new ExceptionInspection(new InvalidArgumentException('foo', 123));
    }
}
