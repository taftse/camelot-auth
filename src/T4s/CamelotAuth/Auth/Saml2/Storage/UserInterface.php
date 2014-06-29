<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 29/06/2014
 * Time: 13:46
 */

namespace T4s\CamelotAuth\Auth\Saml2\Storage;


interface UserInterface {
    public function getAccount();

    public function getEntity();

    public function getPersistantID();

} 