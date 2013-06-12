<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Requests;

use T4s\CamelotAuth\Auth\Oauth1Client\Requests\AbstractRequest;

class RequestTokenRequest extends AbstractRequest
{
		protected $name = 'request';
		
		protected $required = array(
				'oauth_callback' => TRUE,
				'oauth_consumer_key' => TRUE,
				'oauth_signature_method' => TRUE,
				'oauth_signature' => TRUE,
				'oauth_timestamp' => TRUE,
				'oauth_nonce' => TRUE,
				'oauth_version' => TRUE,
				);
}