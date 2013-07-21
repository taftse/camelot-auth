<?php namespace T4s\CamelotAuth\Repositories;


interface AccountRepositoryInterface
{
	public function isActive();

	public function getByID($account_ID);
}