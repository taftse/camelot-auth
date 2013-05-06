<?php namespace TwswebInt\CamelotAuth\Models;

interface LocalAccountThrotelleInterface
{
	public function getByCredentials(array $credentials);
}