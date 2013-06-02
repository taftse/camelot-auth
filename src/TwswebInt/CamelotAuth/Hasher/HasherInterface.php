<?php namespace TwswebInt\CamelotAuth\Hasher;

interface HasherInterface
{
	public function hash($string);

	public function check($string,$hashedString);
}