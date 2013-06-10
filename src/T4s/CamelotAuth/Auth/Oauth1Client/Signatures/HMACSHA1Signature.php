<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Signatures;

use T4s\CamelotAuth\Auth\Oauth1Client\Signatures\AbstractSignature;

class HMACSHA1Signature extends AbstractSignature
{

	public function sign($request,$token = null)
	{
		$key = $this->key($token);

		$base_string = $request->base_string();

		return base64_encode(hash_hmac('sha1',$base_string, $key,TRUE));
	}
}