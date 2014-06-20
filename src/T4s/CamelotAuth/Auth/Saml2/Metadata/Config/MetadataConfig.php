<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Config;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\MetadataInterface;
use T4s\CamelotAuth\Config\ConfigInterface;

class MetadataConfig implements MetadataInterface{

    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function importMetadata()
    {

    }

    public function generateMetadata()
    {

    }

    public function isValidEnitity($entityID)
    {
       if(isset($this->config->get('saml2metadata.metadata')[$entityID]))
       {
           return true;
       }
        return false;
    }

   /*public function getEntity($entityID)
    {
        return new EntityDescriptor();
    }
*/


    public function getEntityDescriptor($entityID)
    {
        if(!$this->isValidEnitity($entityID))
        {
            throw new \Exception("unknown Entity ".$entityID);
        }
        $entityDetails = $this->config->get('saml2metadata.metadata')[$entityID];
        $entityDetails['entityid'] = $entityID;
        return new EntityDescriptor($entityDetails);
    }



} 