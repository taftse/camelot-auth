<?php 
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


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


	public function __construct($binding,$location,$responseLocation = null)
	{
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

	public function toXML($parentNode)
	{
		// more code to come
	}

	public function importXML($xml)
	{
		// more code to come
	}
}