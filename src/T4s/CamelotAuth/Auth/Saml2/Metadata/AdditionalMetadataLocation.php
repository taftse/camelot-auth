<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


class AdditionalMetadataLocation implements SAMLNodeInterface
{
    protected $namespace;

    protected $location;

    public function __construct($location,$namespace)
    {
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

    }
} 