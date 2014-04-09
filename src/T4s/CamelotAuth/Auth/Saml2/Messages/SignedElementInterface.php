<?php namespace T4s\CamelotAuth\Auth\Saml2\Messages;


interface SignedElementInterface
{
	public function validate(\XMLSecurityKey $key);

	public function setCertificates(array $certificates);

	public function getCertificates();

	public function setSignatureKey(\XMLSecurityKey $key);

	public function getSignatureKey();
}