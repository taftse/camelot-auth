<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Database\Eloquent;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Database\Interfaces\ServiceInterface;
use T4s\CamelotAuth\Models\Eloquent\EloquentModel;

class Service extends EloquentModel implements ServiceInterface
{

    protected $table = 'saml2_services';

    protected $fillable = ['entity_id','type','binding','location','default','index'];

    public $timestamps = true;




}

