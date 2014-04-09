<?php namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


class KeyDescriptor{

	/**
	 * Specifies the purpose of the key being described
	 * @var string|null
	 */
	protected $use = null;

	/**
	 *  element that directly or indirectly identifies a key
	 * @var KeyInfo
	 */

	protected $keyInfo = null;


	protected $encriptionMethods = array();



	
	public function __construct($use = null,KeyInfo $keyInfo,EncryptionMethod $encriptionMethod)
	{
		$this->use = $use
	}
}