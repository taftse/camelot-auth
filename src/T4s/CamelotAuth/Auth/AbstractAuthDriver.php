<?php namespace T4s\CamelotAuth\Auth;



use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Storage\StorageInterface;
use T4s\CamelotAuth\Storage\CamelotStorageManager;

class AbstractAuthDriver implements AuthDriverInterface
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
     * @var CamelotStorageManager
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
        $this->storageManager = new CamelotStorageManager($this->config);
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

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getName()
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