<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository {

    protected $model;

    protected $table;

    public function __construct($model = null,$table = null)
    {

        $this->table = $table;

        $modelFile = str_replace('Repositories','',__DIR__). $model.'.php';

        if(!file_exists($modelFile))
        {
            throw new \Exception("Cannot Find the ".ucfirst($modelFile)." Model");
        }
        include_once $modelFile;

        $this->model = 'T4s\CamelotAuth\\'.$model;

        if(!class_exists($this->model,false))
        {
            throw new \Exception("Cannot Find Model class (".$this->model.")");
        }
    }

    public function getAll()
    {
        return $this->getNewModel()->all();
    }

    public function getById($id)
    {
        return $this->getNewModel()->find($id);
    }

    public function delete($model)
    {
        return $model->delete();
    }


    public function save($model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    /**
     * Get the model to be used by the database driver
     *
     * @return class
     */
    public function getNewModel()
    {

       $model = new $this->model();
       $model->setTable($this->table);
        return $model;
    }
} 