<?php namespace T4s\CamelotAuth\Auth\Saml2\Metadata;

interface MetadataStoreInterface
{
	
	public function isValidEnitity($entityID);

	//public function getEntitiesList($entityType);
	
	public function getEntity($entityID,$descriptorType);
}	