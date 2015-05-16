<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Local\Storage\Eloquent\Model;


use Illuminate\Database\Eloquent\Model;

class LocalAccount extends Model {


    public function account()
    {
        return $this->hasMany('T4s\CamelotAuth\Storage\Eloquent\Models\Account');
    }

    public function getPasswordHash()
    {
        return $this->attributes['password_hash'];
    }
} 