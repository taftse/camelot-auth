<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 29/06/2014
 * Time: 17:08
 */

namespace T4s\CamelotAuth\Storage;


interface AccountInterface {

    public function isActive();

    public function getStatus();
} 