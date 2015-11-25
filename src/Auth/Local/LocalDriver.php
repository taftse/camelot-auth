<?php namespace T4S\CamelotAuth\Auth\Local;


use T4S\CamelotAuth\Auth\AbstractAuthDriver;
use T4S\CamelotAuth\Auth\AuthDriverInterface;
use T4S\CamelotAuth\Config\ConfigInterface;
use T4S\CamelotAuth\Cookie\CookieInterface;
use T4S\CamelotAuth\Hasher\BcryptHasher;
use T4S\CamelotAuth\Session\SessionInterface;

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



        if($this->storage->getModel('local')->validateCredentials($localAccount, $credentials))
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