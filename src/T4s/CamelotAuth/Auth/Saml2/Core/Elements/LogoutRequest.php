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

class LogoutRequest extends RequestAbstractType implements SAMLElementInterface
{
    /**
     * attributes
     */

    protected $notOnOrAfter = null;

    protected $reason = null;

    /**
     * elements
     */

    protected $baseID;

    protected $nameID;

    protected $encryptedID;

    protected $sessionIndex;

} 