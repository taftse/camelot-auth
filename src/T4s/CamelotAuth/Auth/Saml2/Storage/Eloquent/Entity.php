<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Storage\Eloquent;


use T4s\CamelotAuth\Auth\Saml2\Storage\EntityInterface;
use T4s\CamelotAuth\Models\Eloquent\EloquentModel;

class Entity extends EloquentModel implements EntityInterface
{

    protected $table = 'saml2_entities';

    protected $fillable = ['entityid'];

    public $timestamps = true;

    public function getEntityID()
    {
        return $this->entityid;
    }
} 