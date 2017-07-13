<?php

use Mockery as m;
use Sroutier\LESKModules\Modules;
use Illuminate\Database\Eloquent\Collection;

class ModulesTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Application
	 */
	protected $app;

	/**
	 * @var ModuleRepositoryInterface
	 */
	protected $repository;

	/**
	 * @var Modules
	 */
	protected $module;

	/**
	 * Set up test.
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();

		$this->app        = m::mock('Illuminate\Foundation\Application');
		$this->repository = m::mock('Sroutier\LESKModules\Contracts\RepositoryInterface');
		$this->module     = new Modules($this->app, $this->repository);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testHasCorrectInstance()
	{
		$this->assertInstanceOf('Sroutier\LESKModules\Modules', $this->module);
	}
}
