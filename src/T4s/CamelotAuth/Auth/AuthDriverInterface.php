<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth;


interface AuthDriverInterface {

    public function check();

    public function user();

    public function authenticate(array $credentials, $remember = false, $login = true);
} 