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
} 