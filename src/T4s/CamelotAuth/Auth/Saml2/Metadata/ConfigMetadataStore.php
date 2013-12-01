<?php namespace T4s\CamelotAuth\Auth\Saml2\Metadata;

use T4s\CamelotAuth\Auth\Saml2\Metadata\MetadataStoreInterface;
use T4s\CamelotAuth\Auth\Saml2\Metadata\EntityMetadata;
use T4s\CamelotAuth\Config\ConfigInterface;

use T4s\CamelotAuth\Auth\Saml2\Exceptions\EntityNotFoundException;

class ConfigMetadataStore implements MetadataStoreInterface
{
	protected $config;

	protected $metadata;

	public function __construct(ConfigInterface $config,$metadataLocation = 'saml2metadata.metadata')
	{
		$this->config = $config;
		$this->importMetadata($this->config->get($metadataLocation));
	}

	protected function importMetadata($metadata)
	{
		foreach ($metadata as $entityID => $entityDescriptor) {
			$this->metadata[$entityID] = new EntityMetadata($entityID,$entityDescriptor);
		}
	}


	public function isValidEnitity($entityID)
	{
		if(!is_string($entityID))
		{
			throw new Exception("the entityID can only be a string");
		}

		if(array_key_exists($entityID, $this->metadata))
		{
			return true;
		}
		return false;
	}

	/*public function getEntitiesList($entityType = null)
	{
		$list = array();
		foreach ($this->metadata as $entityID => $type) {

			if(is_null($entityType) || key($type) == strtoupper($entityType) || key($type) == strtolower($entityType))
			{
				$list[$entityID] = $type['Organization']['OrganizationName'];
			}
		}

		return $list;
	}*/

	public function getEntity($entityID,$descriptorType = null)
	{


		if(!$this->isValidEnitity($entityID)){

			throw new EntityNotFoundException("EntityID (".$entityID.") is not registered in config/saml2.php");
		}

		if(is_null($descriptorType))
		{
			return $this->metadata[$entityID];
		}
		
		if(!$this->metadata[$entityID]->descriptorExists($descriptorType))
		{
			throw new EntityNotFoundException("EntityID (".$entityID.") does not contain a ".$descriptorType);
		}

		return $this->metadata[$entityID]->getDescriptor($descriptorType);
	}
}