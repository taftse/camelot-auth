<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */
namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


class PDPDescriptor extends RoleDescriptor implements SAMLElementInterface
{
    protected $authzService = array();

    protected $assertionIDRequestService = null;

    protected $nameIDFormat = null;

    public function __construct(\DOMElement $metadatNode = null)
    {
        parent::__construct('PDPDescriptor');

        if(!is_null($metadatNode))
        {
            return $this->importXML($metadatNode);
        }
    }

    public function toXML(\DOMElement $parentElement)
    {
        $descriptor = parent::toXML($parentElement);

        foreach($this->authzService as $authzService)
        {
            $authzService->toXML($descriptor);
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

        return $descriptor;
    }

    public function importXML(\DOMElement $node)
    {
        parent::importXML($node);

        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {
                case "AuthzService":
                    $this->authzService[] = new EndpointType($node);
                    break;
                case "AssertionIDRequestService":
                    $this->assertionIDRequestService[] = new EndpointType($node);
                    break;
                case "NameIDFormat":
                    $this->nameIDFormat[] = $node->nodeValue;
                    break;

            }
        }
    }
} 