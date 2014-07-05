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

class Conditions implements SAMLElementInterface
{
    /**
     * attributes
     */

    protected $notBefore = null;

    protected $notOnOrAfter = null;

    /**
     * elements
     */

    /**
     * @var null|array
     */
    protected $condition = null;

    protected $audienceRestriction = null;

    protected $oneTimeUse = null;

    protected $proxyRestriction = null;

    public function setValidAudience(array $audienceRestriction)
    {
        $this->audienceRestriction = $audienceRestriction;
    }

    public function setNotBefore($notBefore = null)
    {
        $this->notBefore = $notBefore;
    }

    public function setNotOnOrAfter($notOnOrAfter = null)
    {
        $this->notOnOrAfter = $notOnOrAfter;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $conditions = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML ,'saml:Conditions');
        $parentElement->appendChild($conditions);

        if(!is_null($this->notBefore))
        {
            $conditions->setAttribute('NotBefore',$this->notBefore);
        }

        if(!is_null($this->notOnOrAfter))
        {
            $conditions->setAttribute('NotOnOrAfter',$this->notOnOrAfter);
        }

        if(!is_null($this->condition))
        {
            foreach($this->condition as $condition)
            {
                $condition->toXML($conditions);
            }
        }

        if(!is_null($this->audienceRestriction))
        {
            foreach($this->audienceRestriction as $ar)
            {
                $ar->toXML($conditions);
            }
        }

        if(!is_null($this->oneTimeUse))
        {
            foreach($this->oneTimeUse as $otu)
            {
                $otu->toXML($conditions);
            }
        }

        if(!is_null($this->proxyRestriction))
        {
            foreach($this->proxyRestriction as $pr)
            {
                $pr->toXML($conditions);
            }
        }
    }

    public function importXML(\DOMElement $node)
    {
        throw new \Exception('unfinished function Conditions->importXML()');
    }
} 