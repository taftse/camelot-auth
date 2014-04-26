<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


class AttributeConsumingService implements SAMLElementInterface
{
    protected $index;

    protected  $isDefault = false;

    protected $serviceName = array();

    protected $serviceDescription = null;

    protected $requestedAttribute = array();

    public function __construct($index,$serviceDescription)
    {

    }

    public function toXML(\DOMElement $parentNode)
    {
      $acs = $parentNode->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:AttributeConsumingService');
      $parentNode->appendChild($acs);

      $acs->setAttribute('index',$this->index);

      if($this->isDefault == true)
      {
          $acs->setAttribute('isDefault','true');
      }

      foreach($this->serviceName as $serviceName)
      {
          $serviceName->toXML($acs);
      }

        if(!is_null($this->serviceDescription))
        {
            foreach($this->serviceDescription as $serviceDescription)
            {
                $serviceDescription->toXML($acs);
            }
        }

        foreach($this->requestedAttribute as $requestedAttribute)
        {
            $requestedAttribute->toXML($acs);
        }

        return $acs;
    }

    public function importXML(\DOMElement $node)
    {

    }
} 