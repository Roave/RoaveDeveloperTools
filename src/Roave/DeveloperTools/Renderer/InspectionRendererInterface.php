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

namespace Roave\DeveloperTools\Renderer;

use Roave\DeveloperTools\Inspection\InspectionInterface;

/**
 * Interface for renderers capable of producing {@see \Zend\View\Model\ViewModel}
 * or {@see \Zend\Stdlib\ResponseInterface} instances from
 * {@see \Roave\DeveloperTools\Inspection\InspectionInterface} instances
 */
interface InspectionRendererInterface
{
    /**
     * Retrieves whether this renderer can render the given inspection
     *
     * @param \Roave\DeveloperTools\Inspection\InspectionInterface $inspection
     *
     * @return bool
     */
    public function canRender(InspectionInterface $inspection);

    /**
     * Retrieves the rendered version of the given interface
     *
     * @param \Roave\DeveloperTools\Inspection\InspectionInterface $inspection
     *
     * @return \Zend\View\Model\ModelInterface|\Zend\Stdlib\ResponseInterface
     */
    public function render(InspectionInterface $inspection);
}
