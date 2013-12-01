<?php namespace T4s\CamelotAuth\Auth\Saml2\Messages;

use T4s\CamelotAuth\Auth\Saml2\Messages\AbstractMessage;

abstract class RequestMessage extends AbstractMessage
{
	

	abstract public function importMetadataSettings(EntityMetadata  $idpMetadata,EntityMetadata $spMetadata)
}
