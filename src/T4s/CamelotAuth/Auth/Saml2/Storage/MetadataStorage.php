<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 19/06/2014
 * Time: 14:35
 */

namespace T4s\CamelotAuth\Auth\Saml2\Storage;


use T4s\CamelotAuth\Auth\Saml2\Metadata\AbstractMetadata;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\MetadataInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Storage\StorageDriver;

class MetadataStorage extends AbstractMetadata implements MetadataInterface
{
    protected $storage;

    public function __construct(ConfigInterface $config, StorageDriver $storage, $entityType,$callbackURL)
    {
        parent::__construct($config,$entityType,$callbackURL);
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
        $entity =  $this->storage->get('entity')->getEntity($entityID);
        if(is_null($entity))
        {
            throw new \Exception("unknown Entity ".$entityID);
        }

        var_dump($entity);
        echo 'bla';
        die();

        return new EntityDescriptor($entity);
    }

}
