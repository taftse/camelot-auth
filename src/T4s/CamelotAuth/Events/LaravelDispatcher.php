<?php namespace T4s\CamelotAuth\Events;

use Illuminate\Events\Dispatcher;

class LaravelDispatcher implements DispatcherInterface
{
		protected $dispatcher;

		public function __construct(Dispatcher $eventDispatcher)
		{
			$this->dispatcher = $eventDispatcher;
		}

		public function fire($event, $payload = array(), $halt = false)
		{
			$this->dispatcher->fire($event, $payload);
		}
}