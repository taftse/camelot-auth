<?php namespace T4s\CamelotAuth\Auth\Local;


use T4s\CamelotAuth\Auth\AbstractAuthDriver;
use T4s\CamelotAuth\Auth\AuthDriverInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Hasher\BcryptHasher;
use T4s\CamelotAuth\Session\SessionInterface;

class LocalDriver extends AbstractAuthDriver implements AuthDriverInterface
{

    public function __construct(ConfigInterface $config,CookieInterface $cookie,SessionInterface $session)
    {
        parent::__construct($config,$cookie,$session);
        $this->storage->loadModel('LocalAccount','Local','local');
        $this->storage->getModel('local')->setHasher(new BcryptHasher());
    }

    public function authenticate(array $credentials, $remember = false, $login = true)
    {
        $this->fireAuthenticateEvent($credentials,$remember,$login);

        $this->lastAttempted = $localAccount = $this->storage->getModel('local')->getByCredentials($credentials);

        if($localAccount->validateCredentials($localAccount, $credentials))
        {
            if($login == true)
            {
                $this->login($localAccount->account,$remember);
            }
            return true;
        }
        return false;
    }



} 