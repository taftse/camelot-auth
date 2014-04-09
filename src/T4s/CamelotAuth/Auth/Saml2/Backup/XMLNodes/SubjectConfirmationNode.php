<?php namespace T4s\CamelotAuth\Auth\Saml2\XMLNodes;

use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;
use DOMElement;

class SubjectConfirmationNode {
	
	protected $method;

	protected $id;

	protected $data;

	public function __construct(DOMElement $subjectConfirmationNode)
	{
		$this->method = $message->getAttribute('Method');

		foreach ($subjectConfirmationNode as $node) {
			switch($node->tagName)
			{
				case 'saml:BaseID':
					# code...
					break;
				case 'saml:NameID':
					# code...
					break;
				case 'saml:EncryptedID':
					# code...
					break;
			}
		}
	}
}