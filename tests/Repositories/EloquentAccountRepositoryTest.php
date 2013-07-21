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

	public function testIsActiveUser()
	{
		$this->repository->shouldReceive('isActive')->once()->andReturn('active');

		$this->assertEquals('active',$this->repository->isActive());
	}
}
