<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 19/06/2014
 * Time: 14:35
 */

namespace T4s\CamelotAuth\Auth\Saml2\Storage;


use T4s\CamelotAuth\Storage\StorageDriver;

class MetadataStorage
{
    protected $storage;

    public function __construct(StorageDriver $storage)
    {
        $this->storage = $storage;
    }
} 