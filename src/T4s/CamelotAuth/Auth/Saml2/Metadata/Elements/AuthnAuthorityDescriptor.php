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

class AuthnAuthorityDescriptor extends RoleDescriptor implements SAMLElementInterface
{

    protected $authnQueryService = array();

    protected $assertionIDRequestService = null;

    protected $nameIDFormat = null;

    public function __construct(\DOMElement $metadatNode = null)
    {
        parent::__construct('AuthnAuthorityDescriptor');

        if(!is_null($metadatNode))
        {
            return $this->importXML($metadatNode);
        }
    }

    public function toXML(\DOMElement $parentElement)
    {
        $descriptor = parent::toXML($parentElement);

        foreach($this->authnQueryService as $aqs)
        {
            $aqs->toXML($descriptor);
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
} 