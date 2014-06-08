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

class Advice implements SAMLElementInterface
{
    protected $assertionIDRef = null;

    protected $assertionURIRef = null;

    protected $assertion = null;

    protected $encryptedAssertion = null;
} 