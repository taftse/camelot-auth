<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 05/07/2014
 * Time: 13:59
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\AttributeConsumingService;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\IDPSSODescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\SPSSODescriptor;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;
use T4s\CamelotAuth\Config\ConfigInterface;

abstract class AbstractMetadata
{

    protected $myMetadata;

    protected $callbackURL;

    protected $config;


    public function __construct(ConfigInterface $config, $entityType,$callbackURL)
    {
        $this->callbackURL = $callbackURL;
        $this->config = $config;
        $this->myMetadata = new EntityDescriptor($this->config->get('saml2.myEntityID'));


        if(!is_array($entityType))
        {
            $entityType = [$entityType];
        }

        foreach($entityType as $entity)
        {
            switch($entity)
            {
                case 'IDP':
                    $this->generateMyIDPSSODescriptor();
                    break;
                case 'SP':
                    $this->generateMySPSSODescriptor();
                    break;
            }
        }

    }
    public function getMyMetadata()
    {
        return $this->myMetadata;
    }



    protected function generateMyIDPSSODescriptor()
    {
        $idpDescriptor  = new IDPSSODescriptor();
        // add certificates
        $idpDescriptor->addCertificate($this->config->get('saml2.certificate')['public']);

        $idpDescriptor->addNameIDFormat(Saml2Constants::NameID_Transient);
        $idpDescriptor->addNameIDFormat(Saml2Constants::NameID_Persistent);
        // add single sign on services
        $idpDescriptor->addSingleSignOnService(Saml2Constants::Binding_HTTP_Redirect,$this->callbackURL.'/SSS');
        $idpDescriptor->addSingleSignOnService(Saml2Constants::Binding_HTTP_POST,$this->callbackURL.'/SSO');
        // add single logout service
        $idpDescriptor->addSingleLogoutService(Saml2Constants::Binding_HTTP_POST,$this->callbackURL.'/SLO');

        $this->myMetadata->addRoleDescriptor($idpDescriptor);
    }

    protected function generateMySPSSODescriptor()
    {
        $spDescriptor  = new SPSSODescriptor();
        // add certificates
        $spDescriptor->addCertificate($this->config->get('saml2.certificate')['public'],'signing');
        $spDescriptor->addCertificate($this->config->get('saml2.certificate')['public'],'encryption');

        $spDescriptor->addNameIDFormat(Saml2Constants::NameID_Persistent);

        // assertion consuming service
        $spDescriptor->addAssertionConsumingService(1,Saml2Constants::Binding_HTTP_POST,$this->callbackURL.'/ACS');
        $spDescriptor->addAssertionConsumingService(2,Saml2Constants::Binding_HTTP_Artifact,$this->callbackURL.'/ACS');
        //$spDescriptor->addAssertionConsumingService(3,Saml2Constants::Binding_,$this->callbackURL.'/ACS');
        $acs = new AttributeConsumingService(0,$this->config->get('saml2.serviceDescription'));

        $attributeDetails = $this->config->get('saml2attributes.attributes');

        foreach ($this->config->get('saml2.requestedAttributes') as $friendlyName =>$attribute)
        {
            $required = $attribute['required'];
            $attribute = $attributeDetails[$friendlyName];

            $acs->addRequestedAttribute($attribute['oid'],$attribute['format'],$friendlyName,$required);
        }

        $spDescriptor->addAttributeConsumingService($acs);

        $this->myMetadata->addRoleDescriptor($spDescriptor);
    }

} 