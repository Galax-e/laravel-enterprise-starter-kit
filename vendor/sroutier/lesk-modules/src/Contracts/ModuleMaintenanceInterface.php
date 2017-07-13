<?php
namespace Sroutier\LESKModules\Contracts;

interface ModuleMaintenanceInterface
{
    /**
     * Initialize the specified module.
     *
     * @return bool
     */
    static public function initialize();

    /**
     * Uninitialize the specified module.
     *
     * @return bool
     */
    static public function uninitialize();

	/**
	 * Enables the specified module.
	 *
	 * @return bool
	 */
    static public function enable();

	/**
	* Disables the specified module.
	*
	* @return bool
	*/
    static public function disable();
}
