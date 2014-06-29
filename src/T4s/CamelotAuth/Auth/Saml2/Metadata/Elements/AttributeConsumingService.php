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

    protected $isDefault = false;

    protected $serviceNames = array();

    protected $serviceDescriptions = null;

    protected $requestedAttributes = array();

    public function __construct($index = null,$serviceDescription = null)
    {
        if($index instanceof \DOMElement)
        {
            return $this->importXML($index);
        }

        $this->index = $index;
        $this->serviceDescriptions = $serviceDescription;
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

      foreach($this->serviceNames as $serviceName)
      {
          $serviceName->toXML($acs);
      }

        if(!is_null($this->serviceDescriptions))
        {
            foreach($this->serviceDescriptions as $serviceDescription)
            {
                $serviceDescription->toXML($acs);
            }
        }

        foreach($this->requestedAttributes as $requestedAttribute)
        {
            $requestedAttribute->toXML($acs);
        }

        return $acs;
    }

    public function importXML(\DOMElement $node)
    {
        if(!$node->hasAttribute('index'))
        {
            throw new \Exception("This AttributeConsumingService is missing the required index attribute");
        }
        $this->index = $node->getAttribute('index');

        if($node->hasAttribute('isDefault'))
        {
            $this->isDefault = $node->getAttribute('isDefault');
        }

        foreach($node->childNodes as $node)
        {
            switch($node->localName)
            {
                case "ServiceName":
                    $this->serviceNames[$node->getAttribute('xml:lang')] = $node->nodeValue;
                    break;
                case "ServiceDescription":
                    $this->serviceDescriptions[$node->getAttribute('xml:lang')] = $node->nodeValue;
                    break;
                case "RequestedAttribute":
                    $this->requestedAttributes[] = new RequestedAttribute($node);
                    break;
            }
        }
    }
} 