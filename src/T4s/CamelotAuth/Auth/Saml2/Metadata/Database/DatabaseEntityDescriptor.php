<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Database;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;

class DatabaseEntityDescriptor extends EntityDescriptor{

    protected $serviceLocationRepository;

    protected $certificatesRepository;

    protected $contactsRepository;

    protected $entity;

    public function __construct($entity,
                                ServicesRepository $serviceLocationRepository,
                                CertificatesRepository $certificatesRepository,
                                ContactsRepository $contactsRepository)
    {
        $this->importModel($entity);
    }
} 