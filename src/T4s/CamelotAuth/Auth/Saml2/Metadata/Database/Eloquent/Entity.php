<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Database\Eloquent;


use Illuminate\Database\Eloquent\Model;

class Entity extends Model{

    protected $table = 'saml2_entities';

    public function __construct($table = null)
    {
        if(!is_null($table))
        {
            $this->table = $table;
        }
    }

} 