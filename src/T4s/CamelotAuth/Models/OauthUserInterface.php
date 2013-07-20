<?php namespace T4s\CamelotAuth\Models;

interface OauthUserInterface
{
	public function Account();

	public static function find($id);
}