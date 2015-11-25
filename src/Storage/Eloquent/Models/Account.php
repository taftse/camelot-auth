<?php

namespace T4S\CamelotAuth\Storage\Eloquent\Models;


use Illuminate\Database\Eloquent\Model;

class Account extends Model{


    public function isActivated()
    {
        if($this->attributes['status'] == 'active')
        {
            return true;
        }
        return false;
    }

    public function getStatus()
    {
        return $this->attributes['status'];
    }
} 