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

namespace Roave\DeveloperTools\Mvc\Inspection;

use Roave\DeveloperTools\Inspection\InspectionInterface;
use Zend\Stdlib\RequestInterface;

/**
 * An inspection that contains the current request
 */
class RequestInspection implements InspectionInterface
{
    const DATA_REQUEST = 'request';

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        // ensure immutability via serialization
        $this->request = unserialize(serialize($request));
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->request);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->request = unserialize($serialized);
    }

    /**
     * {@inheritDoc}
     *
     * @return RequestInterface[]
     */
    public function getInspectionData()
    {
        return [static::DATA_REQUEST => clone $this->request];
    }
}
