<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Core\Messages;


use T4s\CamelotAuth\Auth\Saml2\Core\Elements\Assertion;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\EncryptedAssertion;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\StatusResponse;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;


class Response extends StatusResponse
{

    protected $assertions;

    protected $encryptedAssertions;

    public function __construct($message,EntityDescriptor $spMetadata = null)
    {
        parent::__construct('Response',$message);

        if(is_null($message))
        {
            return;
        }

        if($message instanceof EntityDescriptor)
        {
            $this->importMetadataSettings($message,$spMetadata);
        }
        else if($message instanceof \DOMElement)
        {

            $this->importXML($message);
        }
    }

    public function importXML(\DOMElement $node)
    {
        parent::importXML($node);

        foreach($node->childNodes as $node)
        {
            if($node->namespaceURI != Saml2Constants::Namespace_SAML)
            {
                continue;
            }

            switch($node->localName)
            {
                case 'Assertion':
                    $this->assertions[] = new Assertion($node);
                    break;
                case 'EncryptedAssertion':
                    $this->encryptedAssertions = new EncryptedAssertion($node);
                    break;
            }
        }
    }

   public function getAssertions()
   {
       return $this->assertions;
   }



} 