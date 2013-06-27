<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Requests;

use T4s\CamelotAuth\Auth\Oauth1Client\Requests\AbstractRequest;

class AuthorizeRequest extends AbstractRequest
{
		protected $name = 'request';
		
		protected $required = array(
				'oauth_token' => TRUE,
				);
}