<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Storage;

abstract class StorageDriver {
    /**
     * @var T4s\CamelotAuth\Config\ConfigInterface
     */
    protected $config;

    protected $models = [ ];


    protected $storages = [ ];


    public function get($storage)
    {
        if(!isset($this->storages[$storage]))
        {
            $this->storages[$storage] = $this->createStorage($storage);
        }

        return $this->storages[$storage];
    }

    abstract  function createStorage($storage);


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

    public function getModels()
    {
       return $this->models;
    }
} 