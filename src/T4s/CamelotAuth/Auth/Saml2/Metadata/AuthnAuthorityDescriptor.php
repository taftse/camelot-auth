<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 19/04/14
 * Time: 14:12
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class AuthnAuthorityDescriptor extends RoleDescriptor implements SAMLNodeInterface
{

    protected $authnQueryService = array();

    protected $assertionIDRequestService = null;

    protected $nameIDFormat = null;

    public function __construct()
    {
          parent::__construct('AuthnAuthorityDescriptor');
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