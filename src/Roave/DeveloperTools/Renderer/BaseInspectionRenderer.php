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
use Zend\View\Model\ViewModel;

/**
 * Renderer that can render a particular inspection type
 */
abstract class BaseInspectionRenderer implements InspectionRendererInterface
{
    /**
     * @var string class/interface name of the supported inspection type
     */
    protected $supportedInspection = InspectionInterface::class;

    /**
     * @var string name of the template to be used with view models produced by this inspection renderer
     */
    protected $templateName = 'roave-developer-tools/base';

    /**
     * {@inheritDoc}
     */
    public function canRender(InspectionInterface $inspection)
    {
        $supportedInspection = $this->supportedInspection;

        return $inspection instanceof $supportedInspection;
    }

    /**
     * {@inheritDoc}
     */
    public function render(InspectionInterface $inspection)
    {
        $viewModel = new ViewModel(['inspection' => $inspection]);

        $viewModel->setTemplate($this->templateName);

        return $viewModel;
    }
}
