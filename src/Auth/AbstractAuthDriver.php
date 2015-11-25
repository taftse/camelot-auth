<?php namespace T4S\CamelotAuth\Auth;



use T4S\CamelotAuth\Config\ConfigInterface;
use T4S\CamelotAuth\Cookie\CookieInterface;
use T4S\CamelotAuth\Exceptions\AccountDeletedException;
use T4S\CamelotAuth\Exceptions\AccountNotActivatedException;
use T4S\CamelotAuth\Exceptions\AccountSuspendedException;
use T4S\CamelotAuth\Session\SessionInterface;
use T4S\CamelotAuth\Storage\StorageInterface;
use T4S\CamelotAuth\Storage\StorageManager;

abstract class AbstractAuthDriver implements AuthDriverInterface
{

    /**
     * The currently authenticated user
     * @var
     */
    protected $account;

    /**
     * The configuration handler
     *
     * @var \T4s\CamelotAuth\Config\ConfigInterface
     */
    protected $config;

    /**
     * The Cookie Driver used by Camelot
     *
     * @var T4s\CamelotAuth\Cookie\CookieInterface;
     */
    protected $cookie;

    /**
     * The Session Driver used by Camelot
     *
     * @var T4s\CamelotAuth\Session\SessionInterface;
     */
    protected $session;

    /**
     * the provider handling the request
     *
     * @var string
     */
    protected $provider;

    /**
     * the default storage driver
     *
     * @var StorageInterface
     */
    protected $storage;

    /**
     * and instance of the storage manager
     *
     * @var StorageManager
     */
    protected $storageManager;

    /**
     * Indicated if the logout method has been called
     *
     * @var bool
     */
    protected $loggedOut = false;

    /**
     * Indicates if a token user retrieval has been attempted.
     *
     * @var bool
     */
    protected $tokenRetrievalAttempted = false;


    public function __construct(ConfigInterface $config,CookieInterface $cookie,SessionInterface $session)
    {
        $this->config = $config;
        $this->cookie = $config;
        $this->session = $session;
        $this->storageManager = new StorageManager($this->config);
        $this->storage = $this->storageManager->driver();
        $this->storage->loadModel('Account');
    }

    public function check()
    {
        return ! is_null($this->user());
    }

    public function user()
    {
        // if the user has just logged out rerurn an empty user
        if ($this->loggedOut) return null;

        // if we have just gotten the user then return that and skip this
        if(is_null($this->account))
        {
            // lets see if we have a session
            $accountId = $this->session->get($this->getSessionName());

            $account = null;
            // if we have a session id then see if we can get the account
            if(!is_null($accountId))
            {
                $account = $this->storage->getModel('Account')->retreiveByAccountID($accountId);
            }

            // if we didnt find any matching account lets see if we have a rememberMe cookie
            $cookie = $this->getRecallerCookie();
            if(is_null($account)&& !is_null($cookie))
            {
                $account = $this->getAccountByRecaller($cookie);

                if($account)
                {
                    $this->updateSession($account->getAccountIdentifier());

                    $this->fireLoginEvent($account, true);
                }
            }
            $this->account = $account;
        }

        // lets check if the account is active

        return $this->account;
    }









    protected function login($account,$remember = false)
    {
        if(!$account->isActivated())
        {
            switch($account->getStatus())
            {
                case 'suspended':
                    throw new AccountSuspendedException('user cannot be logged in as the account has been suspended');
                    break;
                default:
                    throw new AccountNotActivatedException('user cannot be logged in as the account has not been activated');
                    break;

            }

        }

        $this->updateSession($account);

        if($remember == true)
        {

        }

        $this->fireLoginEvent($account,$remember);

        $this->setAccount($account);
    }


    protected function updateSession($id)
    {
        $this->session->put($id,$this->getSessionName());
    }

    protected function getAccountByRecaller($recaller)
    {
        if($this->validateRecaller($recaller) && ! $this->tokenRetrievalAttempted)
        {
            $this->tokenRetrievalAttempted = true;

            list($id,$token)= explode('|',$recaller,2);

            $account = $this->storage->getModel('Account')->retreiveByToken($id,$token);
            if(!is_null($account))
            {
                $this->viaRecaller = true;

            }
            return $account;
        }
    }


    protected  function validateRecaller($recaller)
    {
        // if the recaller is not a string or the string does not contain a pipe | return false
        if(!is_string($recaller)||str_contains($recaller,'|'))
        {
            return false;
        }

        $segments = explode('|', $recaller);

        // if the segemts array contains 2 values
        // and they both contain a value
        // then return true else return false
        return count($segments) == 2 && trim($segments[0]) !== '' && trim($segments[1]) !== '';
    }





    ///////////////////////////////////////////////////////
    ///                     Events                      ///
    ///////////////////////////////////////////////////////
    protected function fireAuthenticateEvent($credentials,$remember,$login)
    {
        if(isset($this->events))
        {
            $this->events->fire('camelot.attempt', [$credentials, $remember,$login]);
        }
    }


    protected function fireLoginEvent($account,$remember = false)
    {
        if(isset($this->events))
        {
            $this->events->fire('camelot.login', [$account, $remember]);
        }
    }

    ///////////////////////////////////////////////////////
    ///              getters and setters                ///
    ///////////////////////////////////////////////////////

    protected function getRecallerCookie()
    {
        return $this->cookie->get($this->getRecallerName());
    }


    public function setAccount($account)
    {
        $this->account = $account;

        $this->loggedOut = false;
    }

    /**
     * sets the authentication provider
     *
     * @param $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getSessionName()
    {
        return 'camelot-login_'.md5(get_class($this));
    }

    /**
     * Get the name of the cookie used to store the "recaller".
     *
     * @return string
     */
    public function getRecallerName()
    {
        return 'camelot-remember_'.md5(get_class($this));
    }
} 