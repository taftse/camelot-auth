<?php 
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


class IndexedEndpointType extends EndpointType
{
	/**
	 * The index
	 *
	 * @var integer
	 */
	protected $index;

	/**
	 * Is this Endoint default?
	 *
	 * @var boolean
	 */
	protected $isDefault = false;

	public function __construct($binding,$location,$index,$isDefault = false,$responseLocation = null)
	{
		parent::__construct($binding,$location,$responseLocation);

		$this->index 	 = $index;
		$this->isDefault = $isDefault;
	}

	public function toXML($parentNode)
	{
		$node = parrent::toXML($parentNode);


		// more code to come
	}

	public function importXML($xml)
	{
		parrent::importXML($xml);

		// more code to come
	}
}