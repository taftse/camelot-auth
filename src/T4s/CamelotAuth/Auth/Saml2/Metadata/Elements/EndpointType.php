<?php 
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


class EndpointType
{
	/**
	 * The Binding
	 *
	 * @var string
	 */
	protected $binding;

	/**
	 * The URL Location of the endpoint
	 *
	 * @var string
	 */
	protected $location;

	/**
	 * Optionaly specifies a diffrent location where response messages are sent
	 *
	 * @var string|null
	 */
	protected $responseLocation = null;


	public function __construct($binding,$location = null,$responseLocation = null)
	{
        if($binding instanceof \DOMElement)
        {
            return $this->importXML($binding);
        }

		$this->binding 			= $binding;
		$this->location 		= $location;
		$this->responseLocation = $responseLocation;
	}



	public function getLocation()
	{
		return $this->location;
	}

	public function getBinding()
	{
		return $this->binding;
	}

	public function toXML(\DOMElement $parentNode)
	{
		$parentNode->setAttribute('Binding',$this->binding);

        $parentNode->setAttribute('Location',$this->location);

        if(!is_null($this->responseLocation))
        {
            $parentNode->setAttribute('ResponseLocation',$this->responseLocation);
        }

        return $parentNode;
	}

	public function importXML(\DOMElement $xml)
	{
		// more code to come
	}
}