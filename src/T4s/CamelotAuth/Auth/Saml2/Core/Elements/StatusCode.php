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

class StatusCode implements SAMLElementInterface
{
    protected $value;

    /**
     * elements
     */

    /**
     * @var null|StatusCode
     */
    protected $statusCode = null;
} 