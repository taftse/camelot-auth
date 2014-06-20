<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 19/06/2014
 * Time: 14:35
 */

namespace T4s\CamelotAuth\Auth\Saml2\Storage;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Storage\StorageDriver;

class MetadataStorage
{
    protected $storage;

    public function __construct(StorageDriver $storage)
    {
        $this->storage = $storage;
    }

    public function isValidEnitity($entityID)
    {

        if(!is_null($this->storage->get('entity')->getEntity($entityID)))
        {
            return true;
        }
        return false;
    }


    public function getEntityDescriptor($entityID)
    {
        $this->storage->get('entity')->getEntity($entityID);
        if(is_null($entityID))
        {
            throw new \Exception("unknown Entity ".$entityID);
        }

        return new EntityDescriptor($entityID);
    }

}
