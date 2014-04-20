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

use Roave\DeveloperTools\Inspection\ComposerInspection;

/**
 * Tests for {@see \Roave\DeveloperTools\Inspection\ComposerInspection}
 *
 * @covers \Roave\DeveloperTools\Inspection\ComposerInspection
 */
class ComposerInspectionTest extends AbstractInspectionTest
{
    /**
     * {@inheritDoc}
     */
    protected function getInspection()
    {
        return new ComposerInspection(['a' => 'b'], ['c' => 'd'], ['e' => 'f']);
    }

    public function testGetInspectionData()
    {
        $data = $this->getInspection()->getInspectionData();

        $this->assertSame(['a' => 'b'], $data[ComposerInspection::PARAM_COMPOSER_JSON]);
        $this->assertSame(['c' => 'd'], $data[ComposerInspection::PARAM_COMPOSER_LOCK]);
        $this->assertSame(['e' => 'f'], $data[ComposerInspection::PARAM_COMPOSER_INSTALLED]);
    }
}
