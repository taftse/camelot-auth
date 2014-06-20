<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Storage\Eloquent\Saml2;


use T4s\CamelotAuth\Auth\Saml2\Storage\ServiceInterface;


class Service implements ServiceInterface
{

    protected $table = 'saml2_services';

    protected $fillable = ['entity_id','type','binding','location','default','index'];

    public $timestamps = true;




}

