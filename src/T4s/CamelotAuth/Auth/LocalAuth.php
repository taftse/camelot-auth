<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Auth\LocalAuth;
use T4s\CamelotAuth\Auth\LocalAuth\Throttler;
use T4s\CamelotAuth\Event\DispatcherInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;

class LocalAuth extends AbstractAuth implements AuthInterface{

		/**
		 * The Throttler provider
		 *
		 * @var T4s\CamelotAuth\Auth\LocalAuth\Throttler\ThrottlerProviderInterface;
		 */
		protected $throttler;

		/**
		 * The Hashing Provder 
		 *
		 * @var T4s\CamelotAuth\Hasher\HasherInterface;
		 */
		protected $hasher;


		public function __construct(ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database)
		{
			parent::__construct($config,$session,$cookie,$database);

			$hasher = '\\'.ltrim($this->config->get('camelot'));
		}


}