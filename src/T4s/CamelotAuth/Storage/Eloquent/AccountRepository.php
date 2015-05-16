<?php namespace T4s\CamelotAuth\Storage\Eloquent;


use T4s\CamelotAuth\Storage\Eloquent\Models\Account;

class AccountRepository extends AbstractEloquentRepository
{
    public function __construct()
    {
        parent::__construct(new Account());
    }
} 