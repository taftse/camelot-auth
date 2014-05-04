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

    public function createOrUpdateEntity(EntityDescriptor $entity)
    {

        $entityModel = $this->getByEntity($entity->getEntityID());
        if(!is_null($entityModel))
        {
            // update entity
            return $entityModel;
        }

        $entityModel = $this->getNewModel()->fill([
            'uid'=>$entity->getEntityID(),
            ]);

        return $entityModel;
    }

    public function getByEntity($entityID)
    {
       return $this->getNewModel()->where('uid', '=', $entityID)->first();
    }
} 