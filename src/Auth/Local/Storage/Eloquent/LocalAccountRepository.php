<?php namespace T4S\CamelotAuth\Auth\Local\Storage\Eloquent;


use T4S\CamelotAuth\Auth\Local\Storage\Eloquent\Model\LocalAccount;
use T4S\CamelotAuth\Auth\Local\Storage\LocalAccountInterface;
use T4S\CamelotAuth\Hasher\HasherInterface;
use T4S\CamelotAuth\Storage\Eloquent\AbstractEloquentRepository;

class LocalAccountRepository extends AbstractEloquentRepository implements LocalAccountInterface
{
    protected $hasher;

    public function __construct()
    {
        parent::__construct(new LocalAccount());
    }

    public function setHasher(HasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function getByCredentials(array $credentials)
    {
        $query = $this->make(['account']);
        foreach($credentials as $key=>$value)
        {
            if(! str_contains($key,'password'))
            {
                $query->where($key,$value);
            }
        }
        return $query->first();
    }

    public function validateCredentials($localAccount,$credentials)
    {
        return $this->hasher->checkHash($credentials['password'],$localAccount->getPasswordHash());
    }
}

