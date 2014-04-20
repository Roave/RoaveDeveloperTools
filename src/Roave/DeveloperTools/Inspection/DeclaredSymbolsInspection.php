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
 * Inspection used to record currently defined classes/interfaces/traits/functions/constants
 */
class DeclaredSymbolsInspection implements InspectionInterface
{
    const PARAM_INTERFACES = 'interfaces';
    const PARAM_CLASSES    = 'classes';
    const PARAM_TRAITS     = 'traits';
    const PARAM_CONSTANTS  = 'constants';
    const PARAM_FUNCTIONS  = 'functions';

    /**
     * @var string[]
     */
    private $declaredInterfaces;

    /**
     * @var string[]
     */
    private $declaredClasses;

    /**
     * @var string[]
     */
    private $declaredTraits;

    /**
     * @var string[]
     */
    private $declaredFunctions;

    /**
     * @var string[]
     */
    private $declaredConstants;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->declaredInterfaces = get_declared_interfaces();
        $this->declaredClasses    = get_declared_classes();
        $this->declaredTraits     = get_declared_traits();
        $this->declaredFunctions  = get_defined_functions()['user'];
        $constants                = get_defined_constants(true);
        $this->declaredConstants  = isset($constants['user']) ? $constants['user'] : [];
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize(get_object_vars($this));
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        foreach (unserialize($serialized) as $varName => $value) {
            $this->$varName = $value;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return string[][]
     */
    public function getInspectionData()
    {
        return [
            static::PARAM_CLASSES    => $this->declaredClasses,
            static::PARAM_INTERFACES => $this->declaredInterfaces,
            static::PARAM_TRAITS     => $this->declaredTraits,
            static::PARAM_FUNCTIONS  => $this->declaredFunctions,
            static::PARAM_CONSTANTS  => $this->declaredConstants,
        ];
    }
}
