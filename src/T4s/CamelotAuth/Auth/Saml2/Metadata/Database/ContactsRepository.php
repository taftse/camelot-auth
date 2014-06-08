<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Metadata\Database;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\ContactPerson;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Database\Interfaces\EntityInterface;
use T4s\CamelotAuth\Repositories\AbstractRepository;

class ContactsRepository extends AbstractRepository{

    public function createOrUpdateContact(EntityInterface $entity,ContactPerson $contact)
    {
        $contactModel = $this->getContact($entity->getEntityID(),$contact);
        if(!is_null($contactModel))
        {
            return $contactModel;
        }

        $contactModel = $this->getNewModel()->fill([
            'entity_id'     => $entity->getEntityID(),
            'first_name'    => $contact->getGivenName(),
            'last_name'     => $contact->getSurName(),
            'phone'         => $contact->getTelephoneNumber()[0],
            'email'         => $contact->getEmailAddress()[0],
            'type'          => $contact->getType(),
            'company'       => $contact->getCompany(),
            'extension'     => $contact->getExtension()
        ]);
        return $contactModel;
    }

    public function getContact($entityID, ContactPerson $contact)
    {
        $query =  $this->getNewModel()
            ->where('entity_id', "=",  $entityID)
            ->where('type', "=",  $contact->getType());

        if(!is_null($contact->getGivenName()))
        {
            $query->where('first_name','=',$contact->getGivenName());
        }
        if(!is_null($contact->getSurName()))
        {
            $query->where('last_name','=',$contact->getSurName());
        }
        if(!is_null($contact->getTelephoneNumber()))
        {
            foreach($contact->getTelephoneNumber() as $phone)
            {
                $query->where('phone','=',$phone);
            }
        }
        if(!is_null($contact->getEmailAddress()))
        {
            foreach($contact->getEmailAddress() as $email)
            {
                $query->where('email','=',$email);
            }
        }
        if(!is_null($contact->getExtension()))
        {
            $query->where('extension','=',$contact->getExtension());
        }

        if(!is_null($contact->getCompany()))
        {
            $query->where('company','=',$contact->getCompany());
        }

        return $query->first();
    }
} 