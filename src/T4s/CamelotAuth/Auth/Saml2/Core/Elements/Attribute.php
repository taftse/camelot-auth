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

class Attribute implements SAMLElementInterface{

    protected $name;

    protected $nameFormat = null;

    protected $friendlyName = null;

    protected $attributeValue = [ ];

    public function __construct(\DOMElement $attribute = null)
    {

        if(is_null($attribute))
        {
            return;
        }

        $this->importXML($attribute);
    }

    public  function  toXML(\DOMElement $parentNode)
    {

    }

    public function importXML(\DOMElement $attribute)
    {
        if($attribute->hasAttribute('Name'))
        {
            $this->name = $attribute->getAttribute('Name');
        }

        if($attribute->hasAttribute('NameFormat'))
        {
            $this->nameFormat = $attribute->getAttribute('NameFormat');
        }

        foreach($attribute->getElementsByTagName('AttributeValue') as $value)
        {
            $this->attributeValue[] = $value->nodeValue;
        }

    }
} 