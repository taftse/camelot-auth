<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Database\Fluent;

use \Illuminate\Database\Connection;

abstract class FluentDriver {
    /**
     * Laravel connection instance
     *
     * @var \Illuminate\Database\Connection
     */
    protected $connection;

    /**
     * the table to be used
     *
     * @var string
     */
    protected $table;

    public function __construct(Connection $connection,$table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }
} 