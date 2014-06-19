<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Storage;


use T4s\CamelotAuth\Config\ConfigInterface;

class EloquentDriver extends StorageDriver
{
    protected $models = [ ];


    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->setTables($this->config->get('camelot.tables'));
        $this->setModels($this->config->get('camelot.models'));
    }

    /**
    * Set the models to be used by the database driver
    *
    * @param array $models
    * @return T4s\CamelotAuth\Storage\StorageDriver
    */
    public function setModels(array $models)
    {
        $this->models = array_merge($this->models,$models);

        return $this;
    }

    public function createStorage($storage)
    {

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
