<?php namespace T4S\CamelotAuth\Storage\Eloquent;


use T4S\CamelotAuth\Storage\AccountInterface;
use T4S\CamelotAuth\Storage\Eloquent\Models\Account;

class AccountRepository extends AbstractEloquentRepository implements AccountInterface
{
    public function __construct()
    {
        parent::__construct(new Account());
    }

    public function retreiveByAccountID($id)
    {
        return $this->make()->where('id',$id)->first();
    }

    public function retreiveByRecallerToken($id,$token)
    {
        return $this->make()->where('remember_token',$token);
    }
} 