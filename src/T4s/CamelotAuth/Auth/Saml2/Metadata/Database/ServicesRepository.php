<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Database;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Database\Interfaces\EntityInterface;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EndpointType;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\IndexedEndpointType;

use T4s\CamelotAuth\Repositories\AbstractRepository;

class ServicesRepository  extends  AbstractRepository{

    public function createService(EntityInterface $entity,$serviceType,EndpointType $endpoint)
    {

        $index = null;
        $default = false;

        if($endpoint instanceof IndexedEndpointType)
        {
           $index =  $endpoint->getIndex();
           $default = $endpoint->isDefault();
        }

        $service = $this->getNewModel()->fill([
            'entity_id' =>  $entity->getEntityID(),
            'type'      =>  $serviceType,
            'binding'   =>  $endpoint->getBinding(),
            'location'  =>  $endpoint->getLocation(),
            'default'   =>  $default,
            'index'     =>  $index,
        ]);

        return $service;
    }

    public   function deleteByEntity(EntityInterface $entity)
    {
        $model = $this->getNewModel()->where('entity_id','=',$entity->getEntityID());
        if($model == false)
        {
            return$model;
        }

        return $model->delete();
    }


} 