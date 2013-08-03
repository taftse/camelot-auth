<?php namespace T4s\CamelotAuth\Repositories;

interface ThrottlerProviderInterface
{
	public function getLoginAttempts();

	public function addLoginAttempt();

	public function resetLoginAttempts();

	public function suspendAccount();

	public function unSuspendAccount();

	public function isSusspended();

	public function banAccount();

	public function unBanAccount();

	public function status();

	public function save();

	public function isEnabled();

}