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



    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        //$this->setTables($this->config->get('camelot.tables'));
        $this->setModels($this->config->get('camelot.models'));
    }

    public function createStorage($storage)
    {
        $modelFile = __DIR__.'/Eloquent/'.$this->models[$storage]['model'].'.php';
        if(!file_exists($modelFile))
        {
            throw new \Exception('Cannot Find Storage model "'.$modelFile.'" Driver');
        }
        include_once $modelFile;

        $model = "T4s\CamelotAuth\Storage\Eloquent\\".$this->models[$storage]['model'];

        if(!class_exists($model,false))
        {
            throw new \RuntimeException('Storage model "'.$model.'" is not supported');
        }
        return new $model();
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
