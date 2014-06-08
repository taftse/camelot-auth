<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Core\Elements;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\SAMLElementInterface;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

abstract class BaseIDType implements SAMLElementInterface
{
    protected $nameQualifier = null;

    protected $spNameQualifier = null;

    protected $baseType = null;

    public function __construct($baseType)
    {
        $this->baseType = $baseType;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $baseID = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML,'saml:'.$this->baseType);
        $parentElement->appendChild($baseID);

        if(!is_null($this->nameQualifier))
        {
            $baseID->setAttribute('NameQualifier',$this->nameQualifier);
        }

        if(!is_null($this->nameQualifier))
        {
            $baseID->setAttribute('SPNameQualifier',$this->nameQualifier);
        }
    }

    public function importXML(\DOMElement $node)
    {
        if($node->hasAttribute('NameQualifier'))
        {
            $this->nameQualifier = $node->getAttribute('NameQualifier');
        }

        if($node->hasAttribute('SPNameQualifier'))
        {
            $this->spNameQualifier = $node->getAttribute('SPNameQualifier');
        }
    }
} 