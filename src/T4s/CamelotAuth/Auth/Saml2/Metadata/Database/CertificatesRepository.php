<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Database;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Database\Interfaces\EntityInterface;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\KeyDescriptor;
use T4s\CamelotAuth\Repositories\AbstractRepository;

class CertificatesRepository extends AbstractRepository
{
    public function createOrUpdateCertificate(EntityInterface $entity,KeyDescriptor $certificate)
    {

        $certificateModel = $this->getCertificate($entity->getEntityID(),$certificate);
        if(!is_null($certificateModel))
        {
            return $certificateModel;
        }

        //$certificateData = openssl_x509_parse($certificate->getCertificate(),TRUE);
        $certificateModel = $this->getNewModel()->fill([
            'entity_id' => $entity->getEntityID(),
            'data'  =>  $certificate->getCertificate(),
            'type'  =>  $certificate->getUse()
        ]);

        return $certificateModel;
    }

    public function getCertificate($entityID, KeyDescriptor $certificate)
    {
        return  $this->getNewModel()
           ->where('entity_id', "=",  $entityID)
           ->where('data',      "=",  $certificate->getCertificate())
           ->where('type',      "=",  $certificate->getUse())->first();
    }
} 