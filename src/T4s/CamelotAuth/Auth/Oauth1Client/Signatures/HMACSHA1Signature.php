<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Signatures;

use T4s\CamelotAuth\Auth\Oauth1Client\Signatures\AbstractSignature;

class HMACSHA1Signature extends AbstractSignature
{
	protected $name ='HMAC-SHA1';

	public function sign($token = null)
	{
		$key = $this->key($token);

		$baseString = $this->request->getBaseString();

		return base64_encode(hash_hmac('sha1',$baseString, $key,TRUE));
	}

	public function verify($signature,$token = null)
	{
		return $signature === $this->sign($token);
	}
}
