<?php namespace TwswebInt\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use TwswebInt\CamelotAuth\Models\AccountInterface;

class Account extends Model implements AccountInterface
{
	protected $table = 'account'; 
}