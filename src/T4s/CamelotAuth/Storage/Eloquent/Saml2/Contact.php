<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Storage\Eloquent\Saml2;


use T4s\CamelotAuth\Auth\Saml2\Storage\ContactInterface;

class Contact implements ContactInterface
{
    protected $table = 'saml2_contacts';

    protected  $fillable = ['entity_id','first_name','last_name','phone','email','type','extension','company'];

    public $timestamps = true;
}


