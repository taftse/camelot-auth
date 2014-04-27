<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Database;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Repositories\AbstractRepository;

class EntitiesRepository extends AbstractRepository{

    public function createEntity(EntityDescriptor $entity)
    {

        $entityModel = $this->getByEntityID($entity->getEntityID());
        if(!is_null($entityModel))
        {
            return $entityModel;
        }

        $entityModel = $this->model->fill([
            'uid'=>$entity->getEntityID(),
            ]);

        return $entityModel;
    }

    public function getByEntityID($entityID)
    {
       return  $this->model->where('uid', '=', $entityID)->first();
    }
} 