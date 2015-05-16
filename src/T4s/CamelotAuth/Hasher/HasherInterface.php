<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Hasher;


interface HasherInterface {
    /**
     * Hash string.
     *
     * @param  string  $string
     * @return string
     */
    public function hash($string);
    /**
     * Check string against hashed string.
     *
     * @param  string  $string
     * @param  string  $hashedString
     * @return bool
     */
    public function checkHash($string, $hashedString);
} 