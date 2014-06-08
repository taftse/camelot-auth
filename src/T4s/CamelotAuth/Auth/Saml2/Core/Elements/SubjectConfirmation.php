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

class SubjectConfirmation implements SAMLElementInterface
{
    /**
     * attribute
     */

    protected $method;


    /**
     * elements
     */

    /**
     * @var null|BaseIDType|NameID|EncryptedID
     */
    protected $baseID = null;

    /**
     * @var null
     */
    protected $subjectConfirmationData = null;
} 