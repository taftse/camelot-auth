<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Config;

use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Config\ConfigInterface;

class ConfigEntityDescriptor extends EntityDescriptor {

    protected $config;

    public function __construct($entityID,array $entity,ConfigInterface $config)
    {
        $this->attributes['entityID'] = $entityID;
        $this->config = $config;


        $this->importArray($entity);
    }
} 