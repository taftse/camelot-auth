<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


class AdditionalMetadataLocation implements SAMLElementInterface
{
    protected $namespace;

    protected $location;

    public function __construct($location,$namespace = null)
    {
        if($location instanceof \DOMElement)
        {
            return $this->importXML($location);
        }


        $this->location  = $location;
        $this->namespace = $namespace;
    }

    public  function toXML(\DOMElement $parentElement)
    {
        $additionalMetadataLocation = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:AdditionalMetadataLocation',$this->location);
        $parentElement->appendChild($additionalMetadataLocation);

        $additionalMetadataLocation->setAttribute('namespace',$this->namespace);

        return $additionalMetadataLocation;
    }

    public function importXML(\DOMElement $node)
    {
        if(!$node->hasAttribute('namespace'))
        {
            throw new \Exception("This AdditionalMetadataLocation is missing the required namespace attribute");
        }
        $this->namespace = $node->getAttribute('namespace');

        $this->location = $node->nodeValue;
    }
} 