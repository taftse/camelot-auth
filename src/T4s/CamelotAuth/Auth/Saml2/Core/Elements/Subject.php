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

class Subject implements SAMLElementInterface
{
    /**
     * @var null|BaseID|NameID|EncryptedID
     */
    protected $baseID = null;

    /**
     * @var null|array
     */
    protected $subjectConfirmation = null;

    public function addSubjectConfirmation(SubjectConfirmation $subjectConfirmation)
    {
        $this->subjectConfirmation[] = $subjectConfirmation;
    }
} 