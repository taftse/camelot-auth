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

abstract class SubjectQueryAbstractType extends RequestAbstractType implements SAMLElementInterface
{
    protected $subject;


    public function toXML(\DOMElement $parentElement)
    {

    }

    public function importXML(\DOMElement $node)
    {

    }
} 