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

class AuthnContext implements SAMLElementInterface
{
    /**
     * elements
     */

    /**
     * @var null
     */
    protected $authnContextClassRef = null;

    /**
     * @var null|AuthnContextDecl|AuthnContextDeclRef
     */
    protected $authnContextDecl = null;

    /**
     * @var null|array
     */
    protected $authenticatingAuthority = null;
} 