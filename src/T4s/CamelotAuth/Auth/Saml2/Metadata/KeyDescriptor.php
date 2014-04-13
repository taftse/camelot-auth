<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


class KeyDescriptor implements SAMLNodeInterface
{
    protected $use = null;

    protected $keyInfo;

    /**
     * @var null|array
     */
    protected $encryptionMethod = null;

    public function __construct($keyInfo = null)
    {
        $this->keyInfo = $keyInfo;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $descriptor = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:KeyDescriptor');
        $parentElement->appendChild($descriptor);

        if(!is_null($this->use))
        {
            $descriptor->setAttribute('use',$this->use);
        }

        if(!is_null($this->keyInfo))
        {
            $this->keyInfo->toXML($descriptor);
        }

        if(!is_null($this->encryptionMethod))
        {
            foreach($this->encryptionMethod as $method)
            {
                $method->toXML($descriptor);
            }
        }

        return $descriptor;
    }

    public function importXML(\DOMElement $node)
    {

    }
} 