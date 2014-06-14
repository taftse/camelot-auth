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

class RequestedAuthnContext implements SAMLElementInterface
{
    /**
     * attributes
     */

    /**
     *  options "exact","minimum","maximum","better"
     * @var null
     */
    protected $comparison = null;

    /**
     * elements
     */

    /**
     * @var null|array
     */
    protected $authnContextClassRef = array();

    /**
     * @var null|array
     */
    protected $authnContextDeclRef = array();


    public function toXML(\DOMElement $parentElement)
    {

    }

    public function importXML(\DOMElement $node)
    {

    }

} 