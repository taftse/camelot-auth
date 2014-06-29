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

class Assertion implements SAMLElementInterface
{
    /**
     * attributes
     */

    protected $version = "2.0";

    protected $id;

    protected $issueInstant;

    /**
     * Elements
     */

    /**
     * @var Issuer
     */
    protected $issuer;

    protected $signature = null;

    protected $subject = null;

    protected $conditions = null;

    protected $advice = null;

    /**
     * @var null|array
     */
    protected $statement = null;

    /**
     * @var null|array
     */
    protected $authnStatement = null;

    /**
     * @var null|array
     */
    protected $authzDecisionStatement = null;

    /**
     * @var null|array
     */
    protected $attributeStatement = null;


    public function __construct(\DOMElement $assertion = null)
    {
        $this->id = uniqid();
        $this->issueInstant = time();

        if(!is_null($assertion))
        {
            $this->importXML($assertion);
        }
    }

    public function toXML(\DOMElement $parentElement)
    {

    }

    public function importXML(\DOMElement $assertion)
    {
        if(!$assertion->hasAttribute('ID'))
        {
            throw new \Exception("The SAML assertion is missing the ID attribute");
        }
        $this->id = $assertion->getAttribute('ID');

        if($assertion->getAttribute('Version') != '2.0')
        {
            throw new \Exception("Unsupported Version: ".$assertion->getAttribute('Version'));
        }

        $this->issueInstant = \DateTime::createFromFormat('Y-m-d\TH:i:s\Z',$assertion->getAttribute('IssueInstant'))->getTimestamp();

        //$this->issuer = $this->getNode($assertion,'/saml:Issuer')->item(0)->nodeValue;

        $this->sessionNotOnOrAfter = $this->parseSessionNotOnOrAfter($assertion);

        $this->sessionIndex = $this->parseSessionIndex($assertion);

        $this->notBefore = strtotime($this->getNode($assertion,'/saml:Assertion/saml:Conditions[@NotBefore]')->item(0)->getAttribute('NotBefore'));


        foreach($assertion->childNodes as $node)
        {

           switch($node->localName)
           {
               case 'Issuer':
                   $this->issuer = $node->nodeValue;
                   break;
               case 'Subject':
                   //$this->subject = new Subject($node);
                   break;
               case 'Conditions':
                   //$this->conditions = new Conditions($node);
                   break;
               case 'AuthnStatement':
                   $this->authnStatement = new AuthnStatement($node);
                   break;
               case 'AttributeStatement':
                   $this->attributeStatement = new AttributeStatement($node);
                   break;
           }

        }

        //$this->attributes = $this->parseAttributes($assertion);
    }

    protected function parseSessionNotOnOrAfter(\DOMElement $assertion)
    {
        $node = $this->getNode($assertion,'/saml:Assertion/saml:AuthnStatement[@SessionNotOnOrAfter]');

        if($node->length == 0)
        {
            return null;
        }

        return strtotime($node->item(0)->getAttribute('SessionNotOnOrAfter'));
    }

    protected function parseSessionIndex(\DOMElement $assertion)
    {
        $node = $this->getNode($assertion,'/saml:Assertion/saml:AuthnStatement[@SessionIndex]');

        if($node->length == 0)
        {
            return null;
        }

        return $node->item(0)->getAttribute('SessionIndex');
    }

    protected function getNode(\DOMElement $node ,$xpathQuery)
    {
        $xpath = new \DOMXPath($node->ownerDocument);
        $xpath->registerNamespace('samlp' , Saml2Constants::Namespace_SAMLProtocol);
        $xpath->registerNamespace('saml' , Saml2Constants::Namespace_SAML);
        $xpath->registerNamespace('ds' , 'http://www.w3.org/2000/09/xmldsig#');

        return $xpath->query('/samlp:Response'.$xpathQuery);
    }


    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }

    public function getIssuer()
    {
        return $this->issuer;
    }

    public function addConditions(Conditions $conditions)
    {
        $this->conditions = $conditions;
    }

    public function addAuthnStatement(AuthnStatement $authnStatement)
    {
        $this->authnStatement = $authnStatement;
    }

    public function addSubjectConfirmation(SubjectConfirmation $subjectConfirmation)
    {
        if(is_null($this->subject))
        {
            $this->subject = new Subject();
        }
        $this->subject->addSubjectConfirmation($subjectConfirmation);
    }
} 