<?php
/**
* Camelot Auth
*
* @author Timothy Seebus <timothyseebus@tools4schools.org>
* @license http://opensource.org/licences/MIT
* @package CamelotAuth
*/

namespace T4s\CamelotAuth\Auth\Saml2;


use T4s\CamelotAuth\Auth\Saml2\Metadata\MetadataInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Storage\StorageDriver;

class Saml2AttributeResolver
{
    /**
     * The data handeler interface
     *
     * @var \T4s\CamelotAuth\Storage\StorageDriver
     */
    protected $storage;

    /**
     * The configuration handler interface
     *
     * @var \T4s\CamelotAuth\Config\ConfigInterface
     */
    protected  $config;

    protected $metadataStore = null;

    public function __construct(MetadataInterface $metadata, ConfigInterface $config,StorageDriver $storage)
    {
        $this->metadataStore = $metadata;
        $this->storage = $storage;
        $this->config = $config;
    }

    public function getAttributes($spEntityID)
    {

        var_dump($entity);
    }
}