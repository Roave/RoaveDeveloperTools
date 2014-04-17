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

namespace Roave\DeveloperTools\Repository;

use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Repository\Exception\InvalidFilePathException;

/**
 * Interface for repositories capable to fetch/store {@see \Roave\DeveloperTools\Inspection\InspectionInterface}
 */
class FileInspectionRepository implements InspectionRepositoryInterface
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * @param string $basePath Directory where the inspections will be written to
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function get($id)
    {
        if (! is_readable($this->basePath)) {
            throw InvalidFilePathException::fromUnReadableFile($filePath);
        }

        $filePath = $this->getPath($id);

        if (! file_exists($filePath)) {
            return null;
        }

        return unserialize(file_get_contents($filePath));
    }

    /**
     * {@inheritDoc}
     */
    public function add($id, InspectionInterface $inspection)
    {
        $filePath = $this->getPath($id);

        if (! is_writable($this->basePath)) {
            throw InvalidFilePathException::fromUnWritableFile($this->basePath);
        }

        file_put_contents($filePath, serialize($inspection));
    }

    /**
     * @param string $id
     *
     * @return string
     */
    private function getPath($id)
    {
        return $this->basePath . \DIRECTORY_SEPARATOR . preg_replace("/[^a-z0-9.]+/i", "", $id) . "_" . md5($id);
    }
}
