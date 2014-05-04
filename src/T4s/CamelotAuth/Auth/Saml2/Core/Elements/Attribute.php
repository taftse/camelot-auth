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

class Attribute implements SAMLElementInterface{

    protected $name;

    protected $nameFormat = null;

    protected $friendlyName = null;

    protected $value = [ ];

    public  function  toXML(\DOMElement $parentNode)
    {

    }

    public function importXML(\DOMElement $node)
    {

    }
} 