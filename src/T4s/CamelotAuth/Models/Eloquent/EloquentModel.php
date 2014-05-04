<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Models\Eloquent;


use Illuminate\Database\Eloquent\Model;

abstract class EloquentModel extends Model
{

    public function __construct($table = null)
    {
        if(!is_null($table))
        {
            $this->table = $table;
        }
    }

    public function save(array $options = Array())
    {
        if ($this->getDirty()) {
            return parent::save($options);
        } else {
            return parent::touch();
        }
    }
} 