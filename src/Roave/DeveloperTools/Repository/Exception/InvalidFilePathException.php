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

namespace Roave\DeveloperTools\Repository\Exception;

use InvalidArgumentException;

/**
 * Exceptions for I/O and invalid path related issues with persistent repositories
 */
class InvalidFilePathException extends InvalidArgumentException implements ExceptionInterface
{
    /**
     * @param string $path
     *
     * @return self
     */
    public static function fromUnReadableFile($path)
    {
        if (! file_exists($path)) {
            return new self(sprintf('Invalid path provided, the path "%s" does not seem to exist', $path));
        }

        if (is_dir($path)) {
            return new self(sprintf('The provided path "%s" is a directory, and it cannot be read as a file', $path));
        }

        return new self(sprintf('The provided path "%s" is invalid', $path));
    }

    /**
     * @param string $path
     *
     * @return self
     */
    public static function fromUnWritableFile($path)
    {
        if (! file_exists(dirname($path))) {
            return new self(
                sprintf('Invalid path provided, the path "%s" does not seem to have a parent directory', $path)
            );
        }

        if (is_dir($path)) {
            return new self(
                sprintf('The provided path "%s" is a directory, and it cannot be written as a file', $path)
            );
        }

        return new self(sprintf('The provided path "%s" is invalid', $path));
    }
}
