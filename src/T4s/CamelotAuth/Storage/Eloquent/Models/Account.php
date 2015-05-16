<?php

namespace T4s\CamelotAuth\Storage\Eloquent\Models;


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
} 