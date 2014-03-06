<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

use T4s\CamelotAuth\Models\AccountInterface;

use T4s\CamelotAuth\Exceptions\UserNotFoundException;
use T4s\CamelotAuth\Exceptions\AccountPendingActivationException;
use T4s\CamelotAuth\Exceptions\AccountSuspendedException;
use T4s\CamelotAuth\Exceptions\AccountNotActiveException;

abstract class AbstractAuth{

	/**
	 * The currentley authenticated user Account
	 *
	 * @var \T4s\CamelotAuth\AccountInterface 
	*/
	protected $account;

	/**
	 * The session store instance
	 *
	 * @var \T4s\CamelotAuth\Session\SessionInterface
	 */
	protected $session;

	/**
	 * The cookie store instance
	 *
	 * @var \T4s\CamelotAuth\Cookie\CookieInterface
	 */
	protected $cookie;

	/**
	 * The data handeler interface
	 *
	 * @var \T4s\CamelotAuth\database\databaseInterface
	 */
	protected $database;

	 /**
	 * The account handeler interface
	 *
	 * @var \T4s\CamelotAuth\repository\AccountRepositoryInterface
	 */
	protected $accountProvider;

	/**
	 * The event dispatcher instance
	 *
	 * @var \T4s\CamelotAuth\Event\DispatcherInterface
	 */
	protected $dispatcher;

	/**
	 * The requested url
	 *
	 * @var string
	 */ 
	protected $request;

	/** 
	 * The callback base url
	 *
	 * @var string
	 */
	protected $callbackUrl;

	/**
	 * the name of the authentication provider
	 *
	 * @var string
	 */
	protected $provider;

	/**
	 * Indicated if the logout method has been called
	 *
	 * @var bool
	 */
	protected $loggedOut = false;

	/**
	 * the fields required for a successfull registration
	 *
	 * @var array
	 */
	protected $registrationFields = array();





	public function __construct($provider,ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,MessagingInterface $messaging,$path)
	{
		$this->provider 	= $provider; // auth provider (string)
		$this->config 		= $config;
		$this->session 		= $session;
		$this->cookie 		= $cookie;
		$this->database 	= $database;
		$this->messaging	= $messaging;
		$this->path 		= $path; // check path

		// load the account repository 
		$this->accountProvider =  $this->database->loadRepository('Account',$this->config->get('camelot.model'));

		$this->registrationFields = $this->config->get('camelot.required_account_details');

		// set the callback url
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        $this->callbackUrl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->callbackUrl = rtrim($this->callbackUrl , '/');
        if(strpos($this->callbackUrl,'?')!== false)
        {
        	$this->callbackUrl = substr($this->callbackUrl, 0, strrpos($this->callbackUrl, '?'));
        }
	}

	/**
	 * Determine if the current user is authenticated.
	 *
	 * @param bool redirect 
	 * @return bool
	 */
	public function check($redirect = false)
	{
		if(!is_null($this->user()))
		{
			return true;
		}
		
		if($redirect)
		{
			$this->session->put($this->request,'url.intended');
			$this->redirectURI($this->config->get('camelot.login_uri'));
		}
		return false;
	}

	/**
	 * determine if the current user is a guest
	 *
	 * @return bool
	 */
	public function guest()
	{
		return is_null($this->user());
	}

	/**
	 * Get the currentley authenticated user.
	 *
	 * @return \T4s\CamelotAuth\UserInterface
	 */

	public function user()
	{
		if($this->loggedOut) return;

		if(!is_null($this->account))
		{
			return $this->account;
		}

		$id = $this->session->get();

		if(!is_null($id))
		{
			return $this->account = $this->accountProvider->getByID($id);
		}

	}


	protected function createSession(AccountInterface $account,$remember = false)
	{
		if(!$account->isActive())
		{
			switch ($account->getStatus()) {
				case 'pending':
					$exception = new AccountPendingActivationException("account_activation_required");
					break;
				case 'suspended':
					$exception = new AccountSuspendedException("account_suspended");
					break;
				default:
					$exception = new AccountNotActiveException("account_not_active");
					break;
			}
					
			// check if a event dispatcher instance exists
			if(isset($this->dispatcher))
			{
				// fire off a warning shot
				$this->dispatcher->fire('camelot.auth.failed',array_values(compact('credentials','remember','login',$exception->toString())));
			}

			throw $exception;
					
		}

		$id = $account->getID();

		$this->session->put($id);

		if($remember)
		{
			$this->cookie->forever($id);
		}

		if(isset($this->dispatcher))
		{
			$this->dispatcher->dispatch('camelot.auth.'.$this->provider.'.loggedin',array($this->user(),$remember));
		}
		$account->updateLastLogin();
		return $this->account = $account;
	}

	/**
	 * Logout the user 
	 *
	 * @return void
	 */

	public function logout()
	{
		if(isset($this->dispatcher))
		{
			$this->dispatcher->dispatch('camelot.auth.logout',array($this->user()));
		}

		$this->session->forget();
		$this->cookie->forget();

		$this->user = null;

		$this->loggedOut = true;
		return true;
	}

	public function setEventDispatcher(DispatcherInterface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	/**
	 * check if all the required fields are submitted
	 *
	 * @return bool
	 */

	public function checkRequiredRegistrationFields(array $registrationData)
	{
		$requiredFields = null;
		foreach ($this->registrationFields as $field) {
			if(!isset($registrationData[$field]) ||is_null($registrationData[$field]))
			{
				$requiredFields[] = $field;
			}
		}

		if(is_null($requiredFields))
		{
			return true;
		}

		return $requiredFields;
	}

	public function redirectURI($uri,$parematers){

		return $this->redirectURL($host.$uri,$parematers);
	}

	public function redirectURL($url,$parematers = array())
	{
		if(strpos($url, '?'))
		{
			$paramPreflix = '&';
		}
		else
		{
			$paramPreflix = '?';
		}

		foreach ($parematers as $name => $value) {
			$param = urlencode($name);

			if(!is_null($value))
			{
				if(is_array($value))
				{
					foreach ($value as $val) {
						$param .= "[]=" . urlencode($val) . "&" . urlencode($name);
					}
				}else{
					$param .= urlencode($value);
				}
			}
			$url .= $paramPreflix .	$param;
			$paramPreflix = '&';		
		}

		if($_SERVER['SERVER_PROTOCOL'] =='HTTP/1.1' && $_SERVER['REQUEST_METHOD'] =='POST')
		{
			$code = 303;
		}
		else
		{
			$code = 302;
		}

		//header('Location: '.$url,TRUE,$code);
		header('Pragma: no-cache');
		header('Cache-Control: no-cache, must-revalidate');

		$html  = '<html>';
		$html .= '<head>
						<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
						<title>Redirecting</title>
				  </head>';
		$html .= '<body>';
		$html .= '<h1>Redirecting</h1>';
		$html .= '<p> we are redirecting you to: ';
		$html .= '<a id="redirectLink" href="'.htmlspecialchars($url).'">'.htmlspecialchars($url).'</a>';
		$html .= '<script type="text/javascript">document.getElementById("redirectLink").focus();</script>';
		$html .= '</p>';
		$html .= '</body>';
		$html .= '</html>';

		return $html;

	}
}