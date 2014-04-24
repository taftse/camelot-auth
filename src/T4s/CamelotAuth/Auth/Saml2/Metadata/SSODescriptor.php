<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


abstract class SSODescriptor extends RoleDescriptor implements SAMLNodeInterface
{

    /**
     * @var null|array
     */
    protected $artifactResolutionService = null;

    /**
     * @var null|array
     */
    protected $singleLogoutService = null;

    /**
     * @var null|array
     */
    protected $manageNameIDService = null;

    /**
     * @var null|array
     */
    protected $nameIDFormat = null;

    public function __construct($descriptorType,$protocolSupportEnumeration = null)
    {
        parent::__construct($descriptorType,$protocolSupportEnumeration);

    }

    public function toXML(\DOMElement $parentNode)
    {
        $descriptor = parent::toXML($parentNode);

        if(!is_null($this->artifactResolutionService))
        {
            foreach($this->artifactResolutionService as $artifact)
            {
                $artifact->toXML($descriptor);
            }
        }

        if(!is_null($this->singleLogoutService))
        {
            foreach($this->singleLogoutService as $sls)
            {
                $sls->toXML($descriptor);
            }
        }

        if(!is_null($this->manageNameIDService))
        {
            foreach($this->manageNameIDService as $mnids)
            {
                $mnids->toXML($descriptor);
            }
        }

        if(!is_null($this->nameIDFormat))
        {
            foreach($this->nameIDFormat as $nameIDFormat)
            {
                $nameID = $descriptor->ownerDocument->createElementNS(Saml2Constants::Namespace_Metadata,'md:NameIDFormat',$nameIDFormat);
                $descriptor->appendChild($nameID);
            }
        }

        return $descriptor;
    }

    public function addArtifactResolutionService($index,$binding = null,$location = null, $isDefault = false,$responseLocation = null)
    {
        if($index instanceof IndexedEndpointType){
             $index = new IndexedEndpointType($binding,$location,$index,$isDefault,$responseLocation);
        }
        $this->artifactResolutionService[] = $index;
    }


    public function addSingleLogoutService($binding,$location = null,$responseLocation= null)
    {
        if(!$binding instanceof EndpointType)
        {
           $binding = new EndpointType($binding,$location,$responseLocation);
        }

        $this->singleLogoutService[] = $binding;
    }

    public function addManageNameIDService($binding,$location = null,$responseLocation= null)
    {
        if(!$binding instanceof EndpointType)
        {
            $binding = new EndpointType($binding,$location,$responseLocation);
        }

        $this->manageNameIDService[] = $binding;
    }

} 