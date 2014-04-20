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

namespace Roave\DeveloperTools\Inspection;

/**
 * Inspection used to record the information stored in a `composer.json` and `composer.lock` file
 */
class ComposerInspection implements InspectionInterface
{
    const PARAM_COMPOSER_JSON      = 'composer.json';
    const PARAM_COMPOSER_LOCK      = 'composer.lock';
    const PARAM_COMPOSER_INSTALLED = 'installed.json';

    /**
     * @var array
     */
    private $composer;

    /**
     * @var array
     */
    private $composerLock;

    /**
     * @var array
     */
    private $composerInstalled;

    /**
     * @param array $composer          definitions from the `composer.json` file
     * @param array $composerLock      definitions from the `composer.lock` file
     * @param array $composerInstalled definitions from the `installed.json` file
     */
    public function __construct(array $composer, array $composerLock, array $composerInstalled)
    {
        $this->composer          = $composer;
        $this->composerLock      = $composerLock;
        $this->composerInstalled = $composerInstalled;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize(get_object_vars($this));
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        foreach (unserialize($serialized) as $varName => $value) {
            $this->$varName = $value;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return array[][]
     */
    public function getInspectionData()
    {
        return [
            static::PARAM_COMPOSER_JSON      => $this->composer,
            static::PARAM_COMPOSER_LOCK      => $this->composerLock,
            static::PARAM_COMPOSER_INSTALLED => $this->composerInstalled,
        ];
    }
}
