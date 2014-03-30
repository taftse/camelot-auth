<?php namespace T4s\CamelotAuth\Auth\Saml2;

use T4s\CamelotAuth\Auth\AbstractAuth;

use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

use T4s\CamelotAuth\Auth\Saml2\Metadata\ConfigMetadataStore;
use T4s\CamelotAuth\Auth\Saml2\Metadata\DatabaseMetadataStore;

class Saml2Auth extends AbstractAuth
{
	/**
	 * the metadata store instance
	 *
	 * @var array
	 */
	protected $metadataStore = null;

	public function __construct($provider,ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,MessagingInterface $messaging,$path)
	{
		parent::__construct($provider,$config,$session,$cookie,$database,$messaging,$path);
		
		$this->metadataStore = $this->loadMetadataStore();
	}

	public function getMetadata()
	{
		return $this->metadataStore->getEntity($this->config->get('saml2.myEntityID'));
	}

	protected function loadMetadataStore()
	{
		if($this->config->get('saml2.metadata_store')=='config')
		{
			return new ConfigMetadataStore($this->config);
		}
		else if($this->config->get('saml2.metadata_store')=='database')
		{
			return new DatabaseMetadataStore($this->database);
		}

		throw new Exception("metadata_store setting incorect please select ether database or config");
		
	}

	public function getEntitiesList($entityType = null)
	{
		return $this->metadataStore->getEntitiesList($entityType);
	}


	public function getRelayState()
	{
		if(isset($_REQUEST['RelayState']))
		{
			return $_REQUEST['RelayState'];
		}

		return $this->sesssion->get('url.intended_url',$this->config->get('camelot.login_success_route'));
	}
}