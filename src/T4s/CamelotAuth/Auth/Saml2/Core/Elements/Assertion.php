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

} 