<?php namespace T4s\CamelotAuth\Hasher;

interface HasherInterface
{
	public function hash($string);

	public function check($string,$hashedString);
}