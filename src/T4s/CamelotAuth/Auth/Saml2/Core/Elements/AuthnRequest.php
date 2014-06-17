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

class AuthnRequest extends RequestAbstractType implements SAMLElementInterface
{
    /**
     * elements
     */

    protected $subjectc = null;

    protected $nameIDPolicy = null;

    protected $condition = null;

    protected $requestedAuthnContext = null;

    protected $scoping = null;

    /**
     * attributes
     */

    protected $forceAuthn = false;

    protected $isPassive = false;

    protected $assertionConsumerServiceIndex = null;

    protected $assertionConsumerServiceURL = null;

    protected $protocolBinding = null;

    protected $attributeConsumingServiceIndex = null;

    protected $providerName = null;


} 