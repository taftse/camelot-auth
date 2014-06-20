<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Storage\Eloquent\Saml2;


use T4s\CamelotAuth\Auth\Saml2\Storage\EntityInterface;


class Entity implements EntityInterface
{

    protected $table = 'saml2_entities';

    protected $fillable = ['entityid'];

    public $timestamps = true;

    public function getEntityID()
    {
        return $this->arrtibute['entityID'];
    }

    public function getEntity($entityID)
    {
       return $this->where('entityID', '=', $entityID)->first();
    }
} 