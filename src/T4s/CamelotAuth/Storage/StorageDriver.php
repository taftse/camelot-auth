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

    protected $tables = [];


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
     * Set the tables to be used by the storage driver
     *
     * @param array $tables
     * @return T4s\CamelotAuth\Storage\StorageDriver
     */
    public function setTables(array $tables)
    {
        $this->tables = array_merge($this->tables,$tables);

        return $this;
    }

    public function getTables()
    {
        return $this->tables;
    }
} 