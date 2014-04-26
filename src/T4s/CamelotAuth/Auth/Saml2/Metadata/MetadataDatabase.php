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
    protected $metadata;

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
            if($file !== false)
            {
                $metadata = new \DOMDocument();
                $metadata->loadXML($file);

               // $node = $metadata->firstChild;
               // if($node->nodeName == "#comment")
                //{
                //    $node = $node->;
               // }
               // var_dump($node->nodeName);
                foreach($metadata->childNodes as $node)
                {
                    if($node instanceof \DOMElement)
                    {

                        switch($node->nodeName)
                        {
                            case "md:EntitiesDescriptor":
                                $this->metadata[$node->nodeName] = new EntitiesDescriptor($node);
                                break;
                            case "md:EntityDescriptor":
                                $this->metadata[$node->nodeName] = new EntityDescriptor(node);
                                break;
                        }

                    }
                }
            }
        }

        var_dump($this->metadata);


    }

    public function generateMetadata()
    {

    }
} 