<?php namespace T4s\CamelotAuth\Auth;

interface AuthInterface
{
	public function check();

	public function user();

	public function guest();

	public function authenticate(array $credentials, $remember = false,$login = true);

	public function register(array $accountDetails = array());

	public function logout();

}