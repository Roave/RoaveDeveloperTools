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

namespace Roave\DeveloperTools\Mvc\Factory;

use Roave\DeveloperTools\Mvc\Listener\ToolbarInjectorListener;
use Roave\DeveloperTools\Renderer\InspectionRendererInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Factory responsible for instantiating a {@see \Roave\DeveloperTools\Mvc\Listener\ToolbarInjectorListener}
 */
class ToolbarInjectorListenerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ToolbarInjectorListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $inspectionRenderer InspectionRendererInterface */
        $inspectionRenderer = $serviceLocator->get(InspectionRendererInterface::class . '\\Toolbar');

        return new ToolbarInjectorListener(new PhpRenderer(), $inspectionRenderer); // @TODO the PhpRenderer has no helpers here!
    }
}
