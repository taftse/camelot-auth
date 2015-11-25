<?php namespace T4S\CamelotAuth\Storage\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractEloquentRepository {
    /**
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function make(array $with = array())
    {
        return $this->model->with($with);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getById($id,array $with = array())
    {
        return $this->make($with)->find($id);
    }

    public function getFirstBy($key, $value, array $with = array())
    {
        return $this->make($with)->where($key,'=',$value)->first();
    }

    public function getManyBy($key,$value, array $with = array())
    {
        return $this->make($with)->where($key,'=',$value)->get();
    }

    public function has($relation, array $with = array())
    {
        return $this->make($with)->has($relation)->get();
    }
}