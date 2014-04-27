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

class AttributeAuthorityDescriptor extends RoleDescriptor implements SAMLElementInterface
{
    protected $attributeService = array();

    protected $assertionIDRequestService = null;

    protected $nameIDFormat = null;

    protected $attributeProfile = null;

    protected $attribute = null;

    public function __construct(\DOMElement $metadatNode = null)
    {
        parent::__construct('AttributeAuthorityDescriptor');

        if(!is_null($metadatNode))
        {
            return $this->importXML($metadatNode);
        }
    }


    public function toXML(\DOMElement $parentElement)
    {
        $descriptor = parent::toXML($parentElement);

        foreach($this->attributeService as $attributeService)
        {
            $attributeService->toXM($descriptor);
        }

        if(!is_null($this->assertionIDRequestService))
        {
            foreach($this->assertionIDRequestService as $aidrs)
            {
                $aidrs->toXML($descriptor);
            }
        }

        if(!is_null($this->nameIDFormat))
        {
            foreach($this->nameIDFormat as $nameIDFormat)
            {
                $nameIDf = $descriptor->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:NameIDFormat',$nameIDFormat);
                $descriptor->appendChild($nameIDf);
            }
        }

        if(!is_null($this->attributeProfile))
        {
            foreach($this->attributeProfile as $attributeProfile)
            {
                $profile = $descriptor->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:AttributeProfile',$attributeProfile);
                $descriptor->appendChild($profile);
            }
        }

        if(!is_null($this->attribute))
        {
            foreach($this->attribute as $attribute)
            {
                $att = $descriptor->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML,'saml:Attribute',$attribute);
                $descriptor->appendChild($att);
            }
        }
    }

    public function importXML(\DOMElement $node)
    {
        parent::importXML($node);

        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {

                case "AttributeService":
                    $this->attributeService[] = new EndpointType($node);
                    break;
                case "AssertionIDRequestService":
                    $this->assertionIDRequestService[] = new EndpointType($node);
                    break;
                case "NameIDFormat":
                    $this->nameIDFormat[] = $node->nodeValue;
                    break;
                case "AttributeProfile":
                    $this->attributeProfile[] = $node->nodeValue;
                    break;
                case "Attribute":
                    $this->attribute[] = new Attribute($node);
                    break;
            }
        }
    }
} 