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

namespace Roave\DeveloperTools\Inspector;

use Composer\Autoload\ClassLoader;
use ReflectionClass;
use Roave\DeveloperTools\Inspection\ComposerInspection;
use Roave\DeveloperTools\Inspection\NullInspection;
use Zend\EventManager\EventInterface;

/**
 * Inspector that captures composer information into a {@see \Roave\DeveloperTools\Inspection\ComposerInspection}
 */
class ComposerInspector implements InspectorInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ComposerInspection|NullInspection
     */
    public function inspect(EventInterface $event)
    {
        $tryPaths = [
            'composer.json',
            __DIR__ . '/../../../../../../../../composer.json',
        ];
        $composerJson          = [];
        $composerLockJson      = [];
        $composerInstalledJson = [];

        foreach ($tryPaths as $path) {
            if (! file_exists($path)) {
                continue;
            }

            $composerJson = $this->readAndParseJson($path);
            $lockPath     = dirname($path) . '/composer.lock';

            if (file_exists($lockPath)) {
                $composerLockJson = $this->readAndParseJson($lockPath);
            }

            break;
        }

        if (class_exists(ClassLoader::class)) {
            $reflectionClass = new ReflectionClass(ClassLoader::class);
            $installedPath   = dirname($reflectionClass->getFileName()) . '/installed.json';

            if (file_exists($installedPath)) {
                $composerInstalledJson = $this->readAndParseJson($installedPath);
            }
        }

        if (! $composerJson) {
            return new NullInspection();
        }

        return new ComposerInspection($composerJson, $composerLockJson, $composerInstalledJson);
    }

    /**
     * @param string $file
     *
     * @return array
     */
    private function readAndParseJson($file)
    {
        return json_decode(file_get_contents($file), true);
    }
}
