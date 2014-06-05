<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Database\Mysql;

use PDO;

abstract class MySqlDriver {

    /**
     * PDO connection isntance
     *
     * @var \PDO
     */
    protected $connection;

    /**
     * the table to be used
     *
     * @var string
     */
    protected $table;

    public function __construct(PDO $connection,$table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }
} 