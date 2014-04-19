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
 * Inspection that stores a start and end point in time
 */
class TimeInspection implements InspectionInterface
{
    const PARAM_START = 'start';
    const PARAM_END   = 'end';

    /**
     * @var float
     */
    private $start;

    /**
     * @var float
     */
    private $end;

    /**
     * @param float $start
     * @param float $end
     */
    public function __construct($start, $end)
    {
        $this->start = (float) $start;
        $this->end   = (float) $end;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize([$this->start, $this->end]);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        list($this->start, $this->end) = unserialize($serialized);
    }

    /**
     * {@inheritDoc}
     */
    public function getInspectionData()
    {
        return [
            self::PARAM_END   => $this->end,
            self::PARAM_START => $this->start,
        ];
    }
}
