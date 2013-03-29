<?php namespace TwswebInt\CamelotAuth\Models\Eloquent;

use TwswebInt\CamelotAuth\Models\AccountInterface;

class Account extends Model implements AccountInterface
{
	protected $table = 'account'; 
}