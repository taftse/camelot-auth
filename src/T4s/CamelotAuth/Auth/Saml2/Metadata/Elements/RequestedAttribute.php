<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


class RequestedAttribute extends Attribute implements SAMLElementInterface
{
    protected $isRequired = false;

    public function __construct(\DOMElement $xml = null)
    {
        if(!is_null($xml))
        {
            return $this->importXML($xml);
        }
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