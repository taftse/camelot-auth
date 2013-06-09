<?php namespace T4s\CamelotAuth\Models;

interface Oauth2UserInterface
{
	public function Account();

	public static function find($id);
}