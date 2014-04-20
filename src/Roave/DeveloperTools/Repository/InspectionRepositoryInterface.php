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

/**
 * Interface for repositories capable to fetch/store {@see \Roave\DeveloperTools\Inspection\InspectionInterface}
 */
interface InspectionRepositoryInterface
{
    /**
     * Retrieve all stored inspections
     *
     * @return \Roave\DeveloperTools\Inspection\InspectionInterface[]
     */
    public function getAll();

    /**
     * Retrieve an inspection by ID - returns no inspection
     *
     * @param string $id
     *
     * @return \Roave\DeveloperTools\Inspection\InspectionInterface|null
     */
    public function get($id);

    /**
     * Add the given inspection to the repository
     *
     * @param string $id
     * @param InspectionInterface $inspection
     *
     * @return mixed
     */
    public function add($id, InspectionInterface $inspection);
}
