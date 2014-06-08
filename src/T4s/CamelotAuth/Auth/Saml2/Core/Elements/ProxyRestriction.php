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

class ProxyRestriction implements SAMLElementInterface
{
    /**
     * attributes
     */

    /**
     * @var null
     */
    protected $count = null;

    /**
     * elements
     */

    /**
     * @var null|array
     */
    protected $audience = null;
} 