<?php namespace T4s\CamelotAuth\Auth\Local\Storage\Eloquent;


use T4s\CamelotAuth\Auth\Local\Storage\Eloquent\Model\LocalAccount;
use T4s\CamelotAuth\Auth\Local\Storage\LocalAccountInterface;
use T4s\CamelotAuth\Storage\Eloquent\AbstractEloquentRepository;

class LocalAccountRepository extends AbstractEloquentRepository implements LocalAccountInterface
{
    public function __construct()
    {
        parent::__construct(new LocalAccount());
    }

    public function getByCredentials(array $credentials)
    {
        $query = $this->make();
        foreach($credentials as $key=>$value)
        {
            if(! str_contains($key,'password'))
            {
                $query->where($key,$value);
            }
        }
        return $query->first();
    }
}

