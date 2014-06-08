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

class EncryptedID implements SAMLElementInterface
{
    protected $encryptedData;

    /**
     * @var null|array
     */
    protected $encryptedKey = null;


    public function __construct($encryptedData)
    {
        $this->encryptedData = $encryptedData;
    }

    public function toXML(\DOMElement $parentNode)
    {
        $encryptedID = $parentNode->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML ,'saml:EncryptedID');
        $parentNode->appendChild($encryptedID);


        $this->encryptedData->toXML($encryptedID);

        if(!is_null($this->encryptedKey))
        {
            foreach($this->encryptedKey as $key)
            {
                $key->toXML($encryptedID);
            }
        }
    }

    public function importXML(\DOMElement $node)
    {
        //@todo fix this dirty temp function when i find out about xenc
        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {
                case "EncryptedData":

                    $this->encryptedData = $node->nodeValue;
                    break;
                case "EncryptedKey":
                    $this->encryptedKey[] = $node->nodeValue;
            }
        }
    }
} 