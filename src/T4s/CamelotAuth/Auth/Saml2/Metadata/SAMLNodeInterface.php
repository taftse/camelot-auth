<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */


namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


interface SAMLNodeInterface {

    public function  toXML(\DOMElement $parentElement);

    public function  importXML(\DOMElement $node);
} 