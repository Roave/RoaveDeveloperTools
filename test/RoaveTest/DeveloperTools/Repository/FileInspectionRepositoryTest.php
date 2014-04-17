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

namespace RoaveTest\DeveloperTools\Repository;

use PHPUnit_Framework_TestCase;
use Roave\DeveloperTools\Inspection\InspectionInterface;
use Roave\DeveloperTools\Inspection\TimeInspection;
use Roave\DeveloperTools\Inspector\TimeInspector;
use Roave\DeveloperTools\Repository\FileInspectionRepository;
use Traversable;
use Zend\EventManager\EventInterface;

/**
 * Tests for {@see \Roave\DeveloperTools\Repository\FileInspectionRepository}
 *
 * @covers \Roave\DeveloperTools\Repository\FileInspectionRepository
 */
class FileInspectionRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var FileInspectionRepository
     */
    private $repository;

    /**
     * @var string
     */
    private $dir;

    public function setUp()
    {
        $this->dir = realpath(sys_get_temp_dir()) . '/FileInspectionRepository' . uniqid();

        mkdir($this->dir);

        $this->repository = new FileInspectionRepository($this->dir);
    }

    /**
     * @param InspectionInterface $inspection
     *
     * @dataProvider getSupportedPersistedInspections
     */
    public function testBasicPersistence(InspectionInterface $inspection)
    {
        $id = uniqid();

        $this->repository->add($id, $inspection);

        $this->assertEquals($inspection, $this->repository->get($id));
    }

    public function testRetrievesNullOnNonExistingId()
    {
        $this->assertNull($this->repository->get(uniqid()));
    }

    /**
     * @param InspectionInterface $inspection
     *
     * @dataProvider getSupportedPersistedInspections
     */
    public function testRetrievesNullOnNonExistingIdAndNonEmptyRepository(InspectionInterface $inspection)
    {
        $id = uniqid();

        $this->repository->add($id, $inspection);

        $this->assertNull($this->repository->get(uniqid()));
    }

    /**
     * @param InspectionInterface $inspection
     *
     * @dataProvider getSupportedPersistedInspections
     */
    public function testRetrievesSameValuesAcrossMultipleInstances(InspectionInterface $inspection)
    {
        $repository1 = new FileInspectionRepository($this->dir);
        $repository2 = new FileInspectionRepository($this->dir);

        $id = uniqid();

        $repository1->add($id, $inspection);

        $this->assertEquals($inspection, $repository2->get($id));
    }

    /**
     * @param InspectionInterface $inspection
     *
     * @dataProvider getSupportedPersistedInspections
     */
    public function testHandlesPotentiallyHarmfulIdentifiers(InspectionInterface $inspection)
    {
        $id = uniqid();

        $this->repository->add($id, $inspection);

        $this->assertEquals($inspection, $this->repository->get($id));
    }

    /**
     * @param InspectionInterface $inspection
     *
     * @dataProvider getSupportedPersistedInspections
     */
    public function testOverwritesInspections(InspectionInterface $inspection)
    {
        $id = uniqid();

        $this->repository->add($id, new TimeInspection(111, 222));
        $this->repository->add($id, $inspection);

        $this->assertEquals($inspection, $this->repository->get($id));
    }

    /**
     * @param InspectionInterface $inspection
     *
     * @dataProvider getSupportedPersistedInspections
     */
    public function testListsExistingInspectionsWithNoInspections(InspectionInterface $inspection)
    {
        $inspections = $this->repository->getAll();

        $this->assertThat($inspections, $this->logicalOr($this->isInstanceOf('Traversable'), $this->isType('array')));
        $this->assertEmpty($this->repository->getAll());
    }

    /**
     * @param InspectionInterface $inspection
     *
     * @dataProvider getSupportedPersistedInspections
     */
    public function testListsExistingInspections(InspectionInterface $inspection)
    {
        $id1 = uniqid();
        $id2 = uniqid();

        $this->repository->add($id1, $inspection);
        $this->repository->add($id2, $inspection);

        $inspections = $this->repository->getAll();

        $this->assertThat(
            $inspections,
            $this->logicalOr($this->isInstanceOf(Traversable::class), $this->isType('array'))
        );
        $this->assertCount(2, $this->repository->getAll());

        foreach ($inspections as $id => $fetchedInspection) {
            $this->assertInstanceOf(InspectionInterface::class, $fetchedInspection);
            $this->assertTrue(in_array($id, [$id1, $id2]));
        }
    }

    /**
     * @return InspectionInterface[][]
     */
    public function getSupportedPersistedInspections()
    {
        return [
            [new TimeInspection(123, 456)],
        ];
    }
}
