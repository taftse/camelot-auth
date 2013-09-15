<?php namespace T4s\CamelotAuth\Hasher;

class BcryptHasher implements HasherInterface
{

	/**
	 * Default crypt cost factor.
	 *
	 * @var int
	 */
	protected $cost = 8;

	/**
	 * Create a new Bcrypt hasher instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		if (version_compare(PHP_VERSION, '5.3.7') < 0)
		{
			throw new \RuntimeException("Bcrypt hashing requires PHP 5.3.7");
		}
	}

	public function hash($string,array $options = array())
	{
		if(isset($options['cost']))
		{
			$this->cost = $options['cost'];
		}
		return password_hash($string,PASSWORD_BCRYPT,array('cost'=> $this->cost));
	}


	public function check($string,$hashedString,array $options = array())
	{
		return password_verify($string, $hashedString);
	}
		
	public function needsRehash($string,array $options = array())
	{
		if(isset($options['cost']))
		{
			$this->cost = $options['cost'];
		}
		return password_needs_rehash($string,PASSWORD_BCRYPT,array('cost'=> $this->cost));
	}
}
