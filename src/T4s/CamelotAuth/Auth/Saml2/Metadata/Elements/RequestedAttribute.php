<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


use T4s\CamelotAuth\Auth\Saml2\Core\Elements\Attribute;

class RequestedAttribute extends Attribute implements SAMLElementInterface
{
    protected $isRequired = false;

    public function __construct($oid = null,$format = null,$friendlyName = null, $required = false)
    {
        if(!is_null($oid) && $oid instanceof \DOMElement)
        {
            return $this->importXML($oid);
        }
        $this->name = $oid;
        $this->nameFormat = $format;
        $this->friendlyName = $friendlyName;
        $this->isRequired = $required;
    }

    public function toXML(\DOMElement $parentNode)
    {
        $attribute = parent::toXML($parentNode);

        if($this->isRequired ==true)
        {
            $attribute->setAttribute('isRequired','true');
        }

        return $attribute;
    }

    public function importXML(\DOMElement $node)
    {
        if($node->hasAttribute('ID'))
        {
            $this->id = $node->getAttribute('ID');
        }
    }
} 