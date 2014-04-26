<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata;

use T4s\CamelotAuth\Config\ConfigInterface;

class MetadataConfig implements MetadataInterface{

    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function importMetadata()
    {

    }

    public function generateMetadata()
    {

    }
} 