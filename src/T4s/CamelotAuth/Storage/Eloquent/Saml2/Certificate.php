<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Storage\Eloquent\Saml2;

use T4s\CamelotAuth\Auth\Saml2\Storage\CertificateInterface;


class Certificate implements CertificateInterface
{
    protected $table = 'saml2_certificates';

    protected $fillable = ['entity_id','type','data','default','fingerprint','subject'];

    public  $timestamps = true;
} 