<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */
namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


class PDPDescriptor extends RoleDescriptor implements SAMLNodeInterface
{
    protected $authzService = array();

    protected $assertionIDRequestService = null;

    protected $nameIDFormat = null;

    public function __construct()
    {
        parent::__construct('PDPDescriptor');
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
} 