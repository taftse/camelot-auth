<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Config;


use T4s\CamelotAuth\Auth\Saml2\Metadata\AbstractMetadata;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\AttributeConsumingService;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\IDPSSODescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\KeyDescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\SPSSODescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\MetadataInterface;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Storage\Eloquent\Saml2\Certificate;

class MetadataConfig extends AbstractMetadata implements MetadataInterface{



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






