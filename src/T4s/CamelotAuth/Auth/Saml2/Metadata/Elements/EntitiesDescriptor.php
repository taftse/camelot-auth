<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;

use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class EntitiesDescriptor
{

    // attributes

    /**
     * id
     * @var int|null
     */
    protected $id = null;

    protected  $validUntil = null;

    protected  $cacheDuration = null;

    protected $name = null;

    // elements

    protected  $signature = null;

    protected $extensions = null;

    protected $entityDescriptors = array();

    public function __construct($xml = null)
    {
        if($xml instanceof \DOMElement)
        {
            return $this->importXML($xml);
        }
    }


    public function addDescriptor($descriptor)
    {

        if(!$descriptor instanceof EntitiesDescriptor && !$descriptor instanceof EntityDescriptor)
        {
            throw new \Exception("wrong descriptor type this method only accepts EntitiesDescriptor's or EntityDescriptor's");
        }

        $this->entityDescriptors[] = $descriptor;
    }


    public function getEntities()
    {
        return $this->entityDescriptors;
    }





    public function  toXML(\DOMDocument $root )
    {

        $entitiesDescriptor = $root->createElementNS(Saml2Constants::Namespace_Metadata,'md:EntitiesDescriptor');
        $root->appendChild($entitiesDescriptor);



        if(!is_null($this->id))
        {
            $entitiesDescriptor->setAttribute('ID',$this->id);
        }

        if(!is_null($this->validUntil))
        {
            $entitiesDescriptor->setAttribute('validUntil',$this->validUntil);
        }

        if(!is_null($this->cacheDuration))
        {
            $entitiesDescriptor->setAttribute('cacheDuration',$this->cacheDuration);
        }

        if(!is_null($this->name))
        {
            $entitiesDescriptor->setAttribute('name',$this->name);
        }

        if(!is_null($this->signature))
        {
            $this->signature->toXML($entitiesDescriptor);
        }

        if(!is_null($this->extensions))
        {
            $this->extensions->toXML($entitiesDescriptor);
        }

        foreach($this->entityDescriptors as $descriptor)
        {
            $descriptor->toXML($entitiesDescriptor);
        }

        return $root;
    }

    public function importXML(\DOMElement $node)
    {
        if($node->hasAttribute('ID'))
        {
            $this->id = $node->getAttribute('ID');
        }

        if($node->hasAttribute('validUntil'))
        {
            $this->validUntil = $node->getAttribute('validUntil');
        }

        if($node->hasAttribute('cacheDuration'))
        {
            $this->cacheDuration = $node->getAttribute('cacheDuration');
        }

        if($node->hasAttribute('Name'))
        {
            $this->name = $node->getAttribute('Name');
        }

        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {
                case "Signature":
                    //$this->signature = new Signature($node);
                    break;
                case "Extensions":
                    $this->extensions = $node;
                    break;
                case "EntitiesDescriptor":
                    $entities  = new EntitiesDescriptor($node);
                    $this->entityDescriptors = array_merge($this->entityDescriptors,$entities->getEntities());
                    break;
                case "EntityDescriptor":
                    $this->entityDescriptors[] = new EntityDescriptor($node);
                    break;
            }
        }


    }
} 