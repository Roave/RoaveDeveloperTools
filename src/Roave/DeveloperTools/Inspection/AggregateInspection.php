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

use Zend\Stdlib\ArrayUtils;

/**
 * An inspection that contains multiple other inspections
 */
class AggregateInspection implements InspectionInterface
{
    /**
     * @var InspectionInterface[]
     */
    private $inspections;

    /**
     * @param InspectionInterface[] $inspections
     */
    public function __construct($inspections)
    {
        // note: this iteration is only builtin to ensure type-safety
        $this->inspections = array_values(array_map(
            function (InspectionInterface $inspection) {
                return $inspection;
            },
            ArrayUtils::iteratorToArray($inspections)
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->inspections);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->inspections = unserialize($serialized);
    }

    /**
     * {@inheritDoc}
     *
     * @return InspectionInterface[]
     */
    public function getInspectionData()
    {
        return $this->inspections;
    }
}
