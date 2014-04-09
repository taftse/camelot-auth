<?php namespace T4s\CamelotAuth\Auth\Saml2\Metadata;



class EntityMetadata
{
	protected $entityID;

	protected $attributes = array();

	protected $descriptors = array();

	protected $endpoints = array();

	protected $keys = array();

	protected $supportedAttributes = array();

	public function __construct($entityID, $entityMetadata)
	{

		$this->entityID = $entityID;

		if(is_array($entityMetadata))
		{
			$this->importMetadataArray($entityMetadata);
		}
		elseif($entityMetadata instanceof \DOMElement)
		{
			$this->importMetadataXML($entityMetadata);
		}
		else
		{
			throw new Exception("unknown metadata type currently only config or xml metadata supported");
		}
	}

	protected function importMetadataArray($entityMetadata = array())
	{
		foreach ($entityMetadata as $key => $value) {
			if(is_array($value))
			{
				switch($key)
					{
						case 'Organization':
							$this->organization = $value;
							break;
						case 'ContactPerson':
							$this->contactPerson[] = $value;
							break;
						case 'AdditionalMetadataLocation':
							$this->additionalMetadataLocation[] = $value;							
							break;
						case 'Extentions':
							$this->extentions = $value;
							break;

						
						default:
							$this->descriptors[$key][] = $value;
							if(is_array($value))
							{
								foreach ($value as $key2 => $value2) {
									
									switch($key2)
									{
										case 'AssertionConsumerService':
										case 'SingleSignOnService':
										case 'NameIDMappingService':
										case 'AssertionIDRequestService':
											$this->endpoints[$key2][] = $value2;
											break;
										case 'Attributes':
											$this->supportedAttributes[] = $value2;
											break;
										case 'KeyDescriptor':
											$this->keys = $value2;
											break;
									}
								}
							}
							break;
					}
			}
			else
			{
				$this->attributes[$key] = $value;
			}
			
		}
	}

	public function descriptorExists($descriptorType)
	{
		return array_key_exists($descriptorType,$this->descriptors);
	}

	public function getDescriptor($descriptorType)
	{
		if(!$this->descriptorExists($descriptorType))
		{
			throw new \Exception("This Entity does not have a descriptor type of ". $descriptorType);	
		}
		return $this->descriptors[$descriptorType];
	}

	public function getAttribute($attribute,$default = null)
	{
		if(isset($this->attributes[$attribute]))
		{
			return $this->attributes[$attribute];
		}
		return $default;
	}

	public function getValidatedValue($attributeName,$validOptions,$default)
	{
		$returnedAttribute = $this->getAttribute($attributeName,$default);

		if($returnedAttribute === $default)
		{
			return $returnedAttribute;
		}

		if(!in_array($returnedAttribute, $validOptions))
		{
			throw new \Exception("The ".$attributeName." attribute returned an value (".$returnedAttribute.") which is not contained in the array of valid options");
		}

		return $returnedAttribute;
	}

	public function getEndpoints($endpointsType)
	{
		if(!isset($this->endpoints[$endpointsType]))
		{
			return array();
		}
	
		return $this->endpoints[$endpointsType];
	}

	public function getDefaultEndpoint($endpointType, $allowedEndpointBinding = null,$default = null)
	{

		$endpoints = $this->getEndpoints($endpointType);
		$firstAllowed  = null;
		$firstNotFalse = null;
		$returnEndpoint = null;

		foreach ($endpoints as $endpoint) 
		{

			if(!is_null($allowedEndpointBinding) && !in_array($endpoint['Binding'], $allowedEndpointBinding))
			{
				continue;
			}

			if(isset($endpoint['isDefault']))
			{
				if($endpoint['isDefault']===true)
				{
					return $endpoint;
				}

				if(is_null($firstAllowed))
				{
					$firstAllowed = $endpoint;
				}
			}
			else if(is_null($firstNotFalse))
			{
				$firstNotFalse = $endpoint;
			}		
		}

		if(!is_null($firstNotFalse) && is_null($returnEndpoint))
		{
			return $firstNotFalse;
		}
		elseif(is_null($returnEndpoint))
		{
			return $firstAllowed;
		}

		throw new Exception("the identity provider does not supprt the required endpoint Binding (".$allowedEndpointBinding.")");
		
	}

	public function getEntityID()
	{
		return $this->entityID;
	}

	public function getSupportedBindings($endpointsType)
	{
		$endpoints = $this->getEndpoints($endpointsType);

		foreach ($endpoints as $endpoint) {
			$supportedBindings[] = $endpoint['Binding'];
		}
		return $supportedBindings;
	}

	public function getPrivateKey()
	{

	}

	public function getPublicKey($use = null, $required = false)
	{
		foreach ($this->keys as $key) {
			if(!is_null($use) && isset($key['use']) && $key['use'] !== $use)
			{
				// key is not for use so go to the next one
				continue;
			}
		}
	}
}