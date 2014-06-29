<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 29/06/2014
 * Time: 17:07
 */

namespace T4s\CamelotAuth\Storage\Eloquent;


use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Storage\AccountInterface;

class Account extends Model implements AccountInterface
{

    /**
     * The Database table used by the model
     *
     * @var string
     */

    protected $table = 'account';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified',
        'address_1',
        'address_2',
        'city',
        'zip_code',
        'state_code',
        'country_iso',
        'dob',
        'phone',
        'gender',
        'status'
    ];

    public $timestamps = true;


    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function isActive()
    {
        if($this->attributes['status']=='active')
        {
            return true;
        }
        return false;
    }

    public function getStatus()
    {
        return $this->attributes['status'];
    }

    public function getID()
    {
        return $this->attributes['id'];
    }

    public function updateLastLogin()
    {
        $this->attributes['last_login'] = date('Y-m-d H:i:s');
        $this->save();
    }
} 