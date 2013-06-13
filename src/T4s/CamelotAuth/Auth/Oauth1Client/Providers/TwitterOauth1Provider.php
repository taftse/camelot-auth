<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Providers;


class TwitterOauth1Provider extends AbstractOauth1Provider
{


		/**
		 * Returns the Request Token URL for the provider.
		 *
		 * @return string
		 */
		public function requestTokenUrl()
		{
			return 'https://api.twitter.com/oauth/request_token';
		}

		/**
		 * Returns the authorization URL for the provider.
		 *
		 * @return string
		 */
		public function authorizeUrl()
		{
			return 'https://api.twitter.com/oauth/authenticate';
		}


		/**
         * Returns the access token endpoint for the provider.
		 *
		 * @return string
		 */
		public function accessTokenUrl()
		{
			return 'https://api.twitter.com/oauth/access_token';
		}

		public function getUserInfo(array $token)
		{
			$request = $this->newRequest('resource','GET','http://api.twitter.com/1.1/users/lookup.json',array(
						'oauth_consumer_key' => $this->clientID,	
						'oauth_token' => $token['oauth_token'],
						'user_id' => $token['user_id'],
						));

			$signature = $this->loadSignature('HMAC-SHA1',$request);

			$request->sign($signature,$token);

			$user = current(json_decode($request->execute()));
		
	


				$userData['token'] = $token['oauth_token'];
				$userData['token_verifier'] = $token['oauth_verifier'];
				$userData['user_id'] = $token['user_id'];
				$userData['username'] = $user->screen_name;
				list($firstname,$lastname) = explode(' ', $user->name);
				$userData['first_name'] = $firstname;
				$userData['last_name'] = $lastname;
				$userData['email'] = '';
				
				return $userData;

		}
}