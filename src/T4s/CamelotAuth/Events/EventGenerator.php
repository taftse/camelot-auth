<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Events;


trait EventGenerator {
    protected $pendingEvents = array();

    protected function raise($event)
    {
        $this->pendingEvents[] = $event;
    }

    public function releaseEvents()
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = array();
        return $events;
    }
} 