<?php namespace T4s\CamelotAuth\Auth;


use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;

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
     * The Session Driver used by Camelot
     *
     * @var T4s\CamelotAuth\Session\SessionInterface;
     */
    protected $session;

    /**
     * Indicated if the logout method has been called
     *
     * @var bool
     */
    protected $loggedOut = false;

    public function __construct(ConfigInterface $config,SessionInterface $session)
    {
        $this->config = $config;
        $this->session = $session;
    }

    public function check()
    {
        return ! is_null($this->user());
    }

    public function user()
    {
        if ($this->loggedOut) return;

        if(! is_null($this->account))
        {
            return $this->account;
        }

        $userId = $this->session->get($this->getName());


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