<?php namespace T4s\CamelotAuth\Auth\Local;


use T4s\CamelotAuth\Auth\AbstractAuthDriver;
use T4s\CamelotAuth\Auth\AuthDriverInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Session\SessionInterface;

class LocalDriver extends AbstractAuthDriver implements AuthDriverInterface
{

    public function __construct(ConfigInterface $config,CookieInterface $cookie,SessionInterface $session)
    {
        parent::__construct($config,$cookie,$session);
        $this->storage->loadModel('LocalAccount','Local','local');
    }

    public function authenticate(array $credentials, $remember = false, $login = true)
    {
        $this->fireAuthenticateEvent($credentials,$remember,$login);

        $this->storage->getModel('local')->getByCredentials($credentials);
    }
} 