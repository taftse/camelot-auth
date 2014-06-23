<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Core\Elements;


use T4s\CamelotAuth\Auth\Saml2\Core\Messages\AbstractMessage;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\SAMLElementInterface;

class StatusResponse  extends AbstractMessage
{
    /**
     * Attributes
     */



    protected $inResponseTo = null;







    /**
     * elements
     */



    protected $signature = null;

    protected $extensions = null;

    protected $status = null;

    public function toXML()
    {

    }

    public function importXML(\DOMElement $node)
    {
        parent::importXML($node);
    }


} 