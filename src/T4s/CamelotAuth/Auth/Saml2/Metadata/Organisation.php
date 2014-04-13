<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


class Organisation implements  SAMLNodeInterface
{
    protected $extensions = null;

    protected $organisationNames = array();

    protected $organisationDisplayNames = array();

    protected $organisationURLs = array();

    public  function toXML(\DOMElement $parentElement)
    {
        $organisation = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:Organization');
        $parentElement->appendChild($organisation);

        if(!is_null($this->extensions))
        {
            $this->extensions->toXML($organisation);
        }

        foreach($this->organisationNames as $name)
        {
            $name->toXML($organisation);
        }

        foreach($this->organisationDisplayNames as $displayName)
        {
            $displayName->toXML($organisation);
        }

        foreach($this->organisationURLs as $URL)
        {
            $URL->toXML($organisation);
        }



        return $organisation;
    }

    public function importXML(\DOMElement $node)
    {

    }
} 