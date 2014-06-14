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

abstract class RequestAbstractType implements SAMLElementInterface
{
    /**
     * Attributes
     */

    /**
     * @var
     */
    protected $id;

    protected $version = "2.0";

    protected $issueInstant;

    protected $destination  = null;

    protected $consent = null;

    /**
     * elements
     */

    protected $issuer = null;

    protected $signature = null;

    protected $extensions = null;

    public function toXML(\DOMElement $parentElement)
    {

    }

    public function importXML(\DOMElement $node)
    {

    }
} 