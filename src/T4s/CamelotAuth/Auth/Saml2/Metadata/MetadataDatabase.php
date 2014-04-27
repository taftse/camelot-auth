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

    public function __construct(ConfigInterface$config,DatabaseInterface $database)
    {
        $this->config = $config;
        $this->database = $database;
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

        $entityRepository = $this->database->loadRepository('Auth\Saml2\Metadata\Database\EntitiesRepository','entity');
        foreach($this->metadata as $entity)
        {
                $entity = $entityRepository->createEntity($entity);
                $entityRepository->save($entity);
        }
    }

    public function generateMetadata()
    {

    }
} 