<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


class KeyDescriptor implements SAMLElementInterface
{
    protected $use = null;

    protected $keyInfo;

    /**
     * @var null|array
     */
    protected $encryptionMethods = null;

    public function __construct($keyInfo = null)
    {
        if($keyInfo instanceof \DOMElement)
        {
            return $this->importXML($keyInfo);
        }
        $this->keyInfo = $keyInfo;
    }

    public function getCertificate($sanitised = false)
    {
        if($sanitised == true)
        {
        return "-----BEGIN CERTIFICATE-----
".chunk_split(trim(str_replace(PHP_EOL,'',trim($this->keyInfo))),64)."-----END CERTIFICATE-----";
        }

        return chunk_split(trim(str_replace(PHP_EOL,'',trim($this->keyInfo))),64);

    }

    public  function getUse()
    {
        return $this->use;
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

        // @todo revamp this function when its not 23:54 and time for bed
        if(!is_null($this->encryptionMethods))
        {
            foreach($this->encryptionMethods as $method)
            {
                $method->toXML($descriptor);
            }
        }

        return $descriptor;
    }

    public function importXML(\DOMElement $node)
    {
        if($node->hasAttribute('use'))
        {
            $this->use = $node->getAttribute('use');
        }

        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {
                case "KeyInfo":
                    $this->keyInfo = $this->getKeyInfo($node);
                    break;
                case "EncryptionMethod":
                    // @todo implemnt xenc:EncriptionMethodType
                    $this->encryptionMethods[] = $node;
                    break;
            }
        }
    }

    public function getKeyInfo(\DOMElement $node)
    {
      //  var_dump($node);
        echo "<pre>";
       $list =  $node->ownerDocument->getElementsByTagName('X509Certificate');
        var_dump($list->item(0));

       return $list->item(0)->nodeValue;
    }
} 