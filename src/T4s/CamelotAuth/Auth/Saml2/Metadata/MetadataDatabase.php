<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;

use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;

use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntitiesDescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;

class MetadataDatabase implements MetadataInterface
{
    protected $database;
    protected $config;
    protected $metadata = array();

    protected $entityRepository;
    protected $serviceLocationRepository;
    protected $certificatesRepository;
    protected $contactsRepository;

    public function __construct(ConfigInterface$config,DatabaseInterface $database)
    {
        $this->config = $config;
        $this->database = $database;

        $this->entityRepository = $this->database->loadRepository('Auth\Saml2\Metadata\Database\EntitiesRepository','entity');
        $this->serviceLocationRepository = $this->database->loadRepository('Auth\Saml2\Metadata\Database\ServicesRepository','services');
        $this->certificatesRepository = $this->database->loadRepository('Auth\Saml2\Metadata\Database\CertificatesRepository','certificate');
        $this->contactsRepository = $this->database->loadRepository('Auth\Saml2\Metadata\Database\ContactsRepository','contacts');
    }


    public function importMetadata()
    {
        $locations = $this->config->get('saml2metadata.locations');
        foreach($locations as $location)
        {
            if(is_null($location)||$location === "")
            {
                continue;
            }

            $file = file_get_contents($location);
            if($file === false)
            {
                continue;
            }

            $metadata = new \DOMDocument();
            $metadata->loadXML($file);


            foreach($metadata->childNodes as $node)
            {
                if($node instanceof \DOMElement)
                {
                    switch($node->localName)
                    {
                        case "EntitiesDescriptor":
                            $entities  = new EntitiesDescriptor($node);
                            $this->metadata = array_merge($this->metadata,$entities->getEntities());
                            break;
                        case "EntityDescriptor":
                            $this->metadata[] = new EntityDescriptor($node);
                            break;
                    }
                }
            }

        }

        foreach($this->metadata as $entity)
        {
            var_dump($entity);
            $entityModel = $this->entityRepository->createOrUpdateEntity($entity);


            $this->entityRepository->save($entityModel);


            $this->serviceLocationRepository->deleteByEntity($entityModel);

            foreach($entity->getServices() as $service)
            {
                $key = key($service);
                $this->serviceLocationRepository->createService($entityModel,$key,$service[$key])->save();
            }

            if(!is_null($entity->getCertificates()))
            {
                foreach($entity->getCertificates() as $certificate)
                {
                    $this->certificatesRepository->createOrUpdateCertificate($entityModel,$certificate)->save();
                }
            }

            if(!is_null($entity->getContacts()))
            {
                foreach ($entity->getContacts() as $contact)
                {
                    $this->contactsRepository->createOrUpdateContact($entityModel,$contact)->save();
                }
            }
        }
    }

    public function generateMetadata()
    {

    }
} 