<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Requests;

use T4s\CamelotAuth\Auth\Oauth1Client\Requests\AbstractRequest;

class AccessTokenRequest extends AbstractRequest
{
		protected $name = 'access';
		
		protected $required = array(
				'oauth_consumer_key' => TRUE,
				'oauth_token' => TRUE,
				'oauth_signature_method' => TRUE,
				'oauth_signature' => TRUE,
				'oauth_timestamp' => TRUE,
				'oauth_nonce' => TRUE,
				'oauth_version' => TRUE,
				);
}
