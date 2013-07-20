<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Auth\LocalAuth;
use T4s\CamelotAuth\Auth\LocalAuth\Throttler;
use T4s\CamelotAuth\Event\DispatcherInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;

class LocalAuth extends AbstractAuth{

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


		public function __construct(ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,RepositoryInterface $repository)
		{
			# code...
		}
}