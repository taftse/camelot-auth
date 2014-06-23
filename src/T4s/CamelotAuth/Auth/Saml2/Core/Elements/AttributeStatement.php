<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Core\Elements;

use T4s\CamelotAuth\Auth\Saml2\Core\Elements\Attribute;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\SAMLElementInterface;

class AttributeStatement extends Statement implements SAMLElementInterface
{
    /**
     * elements
     */

    /**
     * @var array[Attribute|EncryptedAttribute]
     */
    protected $attribute = [];


    public function __construct(\DOMElement $attributes = null)
    {
        if(is_null($attributes))
        {
            return;
        }

        $this->importXML($attributes);
    }

    public function importXML(\DOMElement $attributes)
    {
        foreach($attributes->childNodes as $attribute)
        {
            switch($attribute->localName)
            {
                case 'Attribute':
                    $this->attribute[] = new Attribute($attribute);
                    break;
                case 'EncryptedAttribute':
                    $this->attribute[] = new EncryptedAttribute($attribute);
                    break;
            }
        }
    }

    public function toXML(\DOMElement $parentElement)
    {

    }
} 