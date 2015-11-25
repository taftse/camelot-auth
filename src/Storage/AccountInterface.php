<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4S\CamelotAuth\Storage;


interface AccountInterface {

    public  function retreiveByAccountID($id);


    public function retreiveByRecallerToken($id,$token);//retreiveByRecaller($cookie);
} 