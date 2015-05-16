<?php namespace T4s\CamelotAuth\Auth;



use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Exceptions\UserNotActivatedException;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Storage\StorageInterface;
use T4s\CamelotAuth\Storage\StorageManager;

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

    public function __construct(ConfigInterface $config,CookieInterface $cookie,SessionInterface $session)
    {
        $this->config = $config;
        $this->cookie = $config;
        $this->session = $session;
        $this->storageManager = new StorageManager($this->config);
        $this->storage = $this->storageManager->driver();
    }

    public function check()
    {
        return ! is_null($this->user());
    }

    public function user()
    {
        if ($this->loggedOut) return null;

        if(is_null($this->account))
        {
            $accountId = $this->session->get($this->getName());

            $account = null;
            if(!is_null($accountId))
            {
                $this->storage->retreiveByAccountID($accountId);
            }
        }

        return $this->account;
    }



    public function setProvider($provider)
    {
        $this->provider = $provider;
    }





    protected function login($account,$remember = false)
    {
        if(!$account->isActivated())
        {
            throw new UserNotActivatedException('user cannot be logged in as the account has not been activated');
        }

        $this->updateSession($account);

        if($remember == true)
        {

        }

        $this->fireLoginEvent($account,$remember);

        $this->setAccount($account);
    }


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


    protected function updateSession($id)
    {
        $this->session->put($id,$this->getSessionName());
    }

    public function setAccount($account)
    {
        $this->account = $account;

        $this->loggedOut = false;
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