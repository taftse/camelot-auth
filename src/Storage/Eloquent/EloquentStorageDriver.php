<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4S\CamelotAuth\Storage\Eloquent;


use T4s\CamelotAuth\Storage\AbstractStorageDriver;
use T4s\CamelotAuth\Storage\StorageInterface;

class EloquentStorageDriver extends AbstractStorageDriver implements StorageInterface
{
    /**
     * list of models
     */
    protected $models;

    public function loadModel($modelName, $authDriver = "",$alias = null)
    {
        if($authDriver != "")
        {
            $authDriver = 'Auth\\'.$authDriver.'\\';
        }

        $modelClass ='T4s\CamelotAuth\\'.$authDriver.'Storage\Eloquent\\'.$modelName.'Repository';
        if(!class_exists($modelClass))
        {
            throw new \InvalidArgumentException("Model [$modelName] not supported.");
        }

        if(is_null($alias))
        {
            $alias = $modelName;
        }

        return $this->models[$alias] = new $modelClass();
    }

    public function getModel($modelName)
    {
        if ( ! isset($this->models[$modelName]))
        {
            throw new \RuntimeException("model [".$modelName."] has not been loaded please load model before use");
        }
        return $this->models[$modelName];

    }
} 