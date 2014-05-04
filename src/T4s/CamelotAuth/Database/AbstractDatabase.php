<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Database;


class AbstractDatabase {

    protected $models = [ ];

    protected $repositories = [ ] ;

    /**
     * Set the tables to be used by the database driver
     *
     * @param array $tables
     * @return \T4s\CamelotAuth\Database\AbstractDatabase
     */
    public function setModels(array $models)
    {
        $this->models = array_merge($this->models,$models);

        return $this;
    }

    /**
     * Get the models to be used by the database driver
     *
     * @return array
     */
    public function getModels()
    {
        return $this->models;
    }

} 