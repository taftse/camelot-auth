<?php namespace T4s\CamelotAuth\Tests\Repositories;

use Mockery as m;
use T4s\CamelotAuth\Camelot;
use PHPUnit_Framework_TestCase;


class EloquentAccountRepositoryTest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{
			$this->repository = m::mock('AccountRepositoryInterface');
	}

	public function testIsActiveAccount()
	{
		$this->repository->shouldReceive('isActive')->once()->andReturn(true);

		$this->assertEquals(true,$this->repository->isActive());
	}

	public function testIsNotActiveAccount()
	{
		$this->repository->shouldReceive('isActive')->once()->andReturn(false);

		$this->assertEquals(false,$this->repository->isActive());
	}
}
