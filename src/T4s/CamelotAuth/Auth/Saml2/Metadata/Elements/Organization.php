<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


class Organization implements  SAMLElementInterface
{
    protected $extensions = null;

    protected $organizationNames = array();

    protected $organizationDisplayNames = array();

    protected $organizationURLs = array();

    public function __construct(\DOMElement $xml = null)
    {
        if(!is_null($xml))
        {
            $this->importXML($xml);
        }
    }

    public  function toXML(\DOMElement $parentElement)
    {
        //@todo revamp this incorrect function when its not 23:30

        $organization = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:Organization');
        $parentElement->appendChild($organization);

        if(!is_null($this->extensions))
        {
            $this->extensions->toXML($organization);
        }

        foreach($this->organizationName as $name)
        {
            $name->toXML($organization);
        }

        foreach($this->organizationDisplayNames as $displayName)
        {
            $displayName->toXML($organization);
        }

        foreach($this->organizationURLs as $URL)
        {
            $URL->toXML($organization);
        }



        return $organization;
    }

    public function importXML(\DOMElement $node)
    {

        foreach($node->childNodes as $node)
        {

            switch($node->localName)
            {
                case "Extensions":
                    $this->extensions = $node;
                    break;
                case "OrganizationName":
                    $this->organizationNames[$node->getAttribute('xml:lang')] = $node->nodeValue;
                    break;
                case "OrganizationDisplayName":
                    $this->organizationDisplayNames[$node->getAttribute('xml:lang')] = $node->nodeValue;
                    break;
                case "OrganizationURL":
                    $this->organizationURLs[$node->getAttribute('xml:lang')] = $node->nodeValue;
                    break;
            }
        }
    }
} 