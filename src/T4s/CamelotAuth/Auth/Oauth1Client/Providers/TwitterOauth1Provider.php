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

		public function getUserInfo(AccessToken $token)
		{
			
		}
}