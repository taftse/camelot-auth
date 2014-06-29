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

class SubjectConfirmationData implements  SAMLElementInterface
{

        /**
         * attributes
         */

    protected $notBefore = null;

    protected $notOnOrAfter = null;

    protected $recipient = null;

    protected $inResponseTo = null;

    protected $address = null;

    public function setNotOnOrAfter($notOnOrAfter)
    {
        $this->notOnOrAfter = $notOnOrAfter;
    }

    public function setInResponseTo($inResponseTo)
    {
        $this->inResponseTo = $inResponseTo;
    }

    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }
} 