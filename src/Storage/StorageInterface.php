<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4S\CamelotAuth\Storage;


interface StorageInterface {

    public function loadModel($modelName,$AuthDriver = null,$alias = null);

    public function getModel($modelName);
} 