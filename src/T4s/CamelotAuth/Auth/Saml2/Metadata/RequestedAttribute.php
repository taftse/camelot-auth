<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 19/04/14
 * Time: 14:07
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


class RequestedAttribute extends Attribute implements SAMLNodeInterface
{
    protected $isRequired = false;

    public function __construct()
    {

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

    }
} 