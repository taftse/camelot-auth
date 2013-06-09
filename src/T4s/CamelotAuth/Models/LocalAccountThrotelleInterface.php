<?php namespace T4s\CamelotAuth\Models;

interface LocalAccountThrotelleInterface
{
	public function getByCredentials(array $credentials);
}