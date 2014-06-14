<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;


interface MetadataInterface {

    public function importMetadata();

    public function generateMetadata();

    public function isValidEnitity($entityID);
} 