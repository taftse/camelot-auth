<?php 
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Elements;


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

	public function __construct($binding,$location = null,$index = null,$isDefault = false,$responseLocation = null)
	{
        if($binding instanceof \DOMElement)
        {
            return $this->importXML($binding);
        }

		parent::__construct($binding,$location,$responseLocation);

		$this->index 	 = $index;
		$this->isDefault = $isDefault;
	}

	public function toXML(\DOMElement $parentElement)
	{
		$node = parrent::toXML($parentElement);

        $node->setAttribute('index',$this->index);

        if($this->isDefault != false)
        {
            $node->setAttribute('isDefault','true');
        }

        return $node;
		// more code to come
	}

	public function importXML(\DOMElement $node)
	{
		parent::importXML($node);

		// more code to come
	}
}