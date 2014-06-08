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

class NameIDType extends BaseIDType implements SAMLElementInterface
{
    protected $format = null;

    protected $spProvidedID = null;

    public function __construct($baseType)
    {
        parent::__construct($baseType);
    }


    public function toXML(\DOMElement $parentNode)
    {
        $nameID = parent::toXML($parentNode);

        if(!is_null($this->format))
        {
            $nameID->setAttribute('Format',$this->format);
        }

        if(!is_null($this->spProvidedID))
        {
            $nameID->setAttribute('SPProvidedID',$this->spProvidedID);
        }
    }

    public function importXML(\DOMElement $node)
    {
        parent::importXML($node);

        if($node->hasAttribute('Format'))
        {
            $this->format = $node->getAttribute('Format');
        }

        if($node->hasAttribute('SPProvidedID'))
        {
            $this->spProvidedID = $node->getAttribute('SPProvidedID');
        }
    }
} 