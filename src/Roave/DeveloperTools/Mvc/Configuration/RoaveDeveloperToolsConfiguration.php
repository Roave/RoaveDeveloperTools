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

namespace Roave\DeveloperTools\Mvc\Configuration;

use Zend\Stdlib\AbstractOptions;

/**
 * RoaveDeveloperTools configuration
 */
class RoaveDeveloperToolsConfiguration extends AbstractOptions
{
    /**
     * @var string[] names of the inspector services
     *               (pointing to instances of {@see \Roave\DeveloperTools\Inspector\InspectorInterface})
     */
    private $inspectors = [];

    /**
     * @var string|null
     */
    private $inspectionsPersistenceDir;

    /**
     * @var string[] names of the toolbar tab renderer services
     *               (pointing to instances of {@see \Roave\DeveloperTools\Renderer\RendererInterface})
     */
    private $toolbarTabRenderers = [];

    /**
     * @var string[] names of the detail renderer services
     *               (pointing to instances of {@see \Roave\DeveloperTools\Renderer\RendererInterface})
     */
    private $detailRenderers = [];

    /**
     * {@inheritDoc}
     */
    public function __construct($options)
    {
        $this->__strictMode__ = true;

        parent::__construct($options);
    }

    /**
     * @return string[]
     */
    public function getInspectors()
    {
        return $this->inspectors;
    }

    /**
     * @param string[] $inspectors
     */
    public function setInspectors(array $inspectors)
    {
        $this->inspectors = array_map(
            function ($inspector) {
                return (string) $inspector;
            },
            $inspectors
        );
    }

    /**
     * @return null|string
     */
    public function getInspectionsPersistenceDir()
    {
        return $this->inspectionsPersistenceDir;
    }

    /**
     * @param null|string $inspectionsPersistenceDir
     */
    public function setInspectionsPersistenceDir($inspectionsPersistenceDir)
    {
        $this->inspectionsPersistenceDir = $inspectionsPersistenceDir;
    }

    /**
     * @return \string[]
     */
    public function getToolbarTabRenderers()
    {
        return $this->toolbarTabRenderers;
    }

    /**
     * @param \string[] $toolbarTabRenderers
     */
    public function setToolbarTabRenderers($toolbarTabRenderers)
    {
        $this->toolbarTabRenderers = array_map(
            function ($tabRenderer) {
                return (string) $tabRenderer;
            },
            $toolbarTabRenderers
        );
    }

    /**
     * @return \string[]
     */
    public function getDetailRenderers()
    {
        return $this->detailRenderers;
    }

    /**
     * @param \string[] $detailRenderers
     */
    public function setDetailRenderers($detailRenderers)
    {
        $this->detailRenderers = array_map(
            function ($tabRenderer) {
                return (string) $tabRenderer;
            },
            $detailRenderers
        );
    }
}
