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

    /**
     * Get the model to be used by the database driver
     *
     * @param $name
     * @param null $tableName
     * @return class
     */
    public function getModel($name,$tableName = null)
    {
        $modelData = $this->models[$name];

        $class = 'T4s\CamelotAuth\Auth\\'.$modelData['model'];

        if(!is_null($tableName))
        {
            $modelData['table'] = $tableName;
        }

        return new $class($modelData['table']);
    }
} 