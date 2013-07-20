<?php namespace T4s\CamelotAuth\Models\Native;

use T4s\CamelotAuth\Models\Native\NativeModel;
use T4s\CamelotAuth\Database\Native\DatabaseInterface;

class NativeAccount extends NativeModel implements AccountInterface
{
	protected $table = 'account';

	public function __construct(DatabaseInterface $db)
	{
		parent::__construct(DatabaseInterface $db);
	}
}