<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Storage\Eloquent;


use T4s\CamelotAuth\Auth\Saml2\Storage\ContactInterface;
use T4s\CamelotAuth\Models\Eloquent\EloquentModel;

class Contact extends EloquentModel implements ContactInterface
{
    protected $table = 'saml2_contacts';

    protected  $fillable = ['entity_id','first_name','last_name','phone','email','type','extension','company'];

    public $timestamps = true;
}


