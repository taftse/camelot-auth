<?php namespace T4s\CamelotAuth\Auth;

interface AuthInterface
{
	public function check();

	public function user();

	public function guest();

	public function authenticate(array $credentials,bool $remember = null, bool $login = null);

	public function register(array $accountDetails = array());

	public function logout();

}