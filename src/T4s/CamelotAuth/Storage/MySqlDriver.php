<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 19/06/2014
 * Time: 15:41
 */

namespace T4s\CamelotAuth\Storage;


class MySqlDriver extends StorageDriver
{
    protected $connection;

    public function __construct(PDO $connection,array $models = [])
    {
        $this->$connection = $connection;
        $this->setModels($models);
    }


    public function createStorage($storage)
    {
        $modelFile = __DIR__.'/MySql/'.$this->models[$storage]['model'].'.php';
        if(!file_exists($modelFile))
        {
            throw new \Exception('Cannot Find Storage model "'.$modelFile.'" Driver');
        }
        include_once $modelFile;

        $model = "T4s\CamelotAuth\Storage\MySql\\".$this->models[$storage]['model'];

        if(!class_exists($model,false))
        {
            throw new \RuntimeException('Storage model "'.$model.'" is not supported');
        }
        return new $model($this->connection,$this->models[$storage]['table']);
    }

} 