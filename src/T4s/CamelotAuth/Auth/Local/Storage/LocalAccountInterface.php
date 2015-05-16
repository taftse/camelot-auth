<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Local\Storage;


interface LocalAccountInterface {

    public  function getByCredentials(array $credentials);

    public function validateCredentials($localAccount,$credentials);
} 