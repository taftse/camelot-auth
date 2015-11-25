<?php namespace T4S\CamelotAuth\Facades;

use Illuminate\Support\Facades\Facade;


class Camelot extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'camelot';
    }

}