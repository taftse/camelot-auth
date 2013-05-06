<?php namespace TwswebInt\CamelotAuth\Events

interface DispatcherInterface
{
	/**
	 * Fire an event and call the listeners.
	 *
	 * @param  string  $event
	 * @param  mixed   $payload
	 * @param  boolean $halt
	 * @return void
	 */
	public function fire($event, $payload = array(), $halt = false);
	
}