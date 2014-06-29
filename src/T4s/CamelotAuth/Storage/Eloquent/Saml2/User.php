<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 29/06/2014
 * Time: 13:48
 */

namespace T4s\CamelotAuth\Storage\Eloquent\Saml2;


use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Auth\Saml2\Storage\UserInterface;

class User extends Model implements UserInterface
{
    protected $table = 'saml2_users';

    protected $fillable = ['account_id','entity_id','persistant_id'];

    public $timestamps = true;

    public function getPersistantID()
    {
        return $this->attribute['persistent_id'];
    }

} 