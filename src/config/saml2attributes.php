<?php

/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

return [

    'attributes' =>[
        //Preferred language: Users preferred language (see RFC1766)
        'preferredLanguage' =>[
            'fullName' => 'Preferred Language',
            'oid'      => '2.16.840.1.113730.3.1.39',
            'urn'      => 'urn:mace:dir:attribute-def:preferredLanguage',
        ],
        //E-Mail: Preferred address for e-mail to be sent to this person
        'mail' =>[
            'fullName' => 'Email',
            'oid'      => '0.9.2342.19200300.100.1.3',
            'urn'      => 'urn:mace:dir:attribute-def:mail',
        ],
        //Home postal address: Home address of the user
        'homePostalAddress' =>[
            'fullName' => 'Home postal address',
            'oid'      => '0.9.2342.19200300.100.1.39',
            'urn'      => 'urn:mace:dir:attribute-def:homePostalAddress',
        ],
        //Business postal address: Campus or office address
        'postalAddress' =>[
            'fullName' => 'Business postal address',
            'oid'      => '2.5.4.16',
            'urn'      => 'urn:mace:dir:attribute-def:postalAddress',
        ],
        //Private phone number
        'homePhone' =>[
            'fullName' => 'Private phone number',
            'oid'      => '0.9.2342.19200300.100.1.20',
            'urn'      => 'urn:mace:dir:attribute-def:homePhone',
        ],
        //Business phone number: Office or campus phone number
        'telephoneNumber' =>[
            'fullName' => 'Business phone number',
            'oid'      => '2.5.4.20',
            'urn'      => 'urn:mace:dir:attribute-def:telephoneNumber',
        ],
        //Mobile phone number
        'mobile' =>[
            'fullName' => 'Mobile phone number',
            'oid'      => '0.9.2342.19200300.100.1.41',
            'urn'      => 'urn:mace:dir:attribute-def:mobile',
        ],
        //Affiliation: Type of affiliation with Home Organization
        'eduPersonAffiliation' =>[
            'fullName' => 'Affiliation',
            'oid'      => '1.3.6.1.4.1.5923.1.1.1.1',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonAffiliation',
        ],
        //Organization path: The distinguished name (DN) of the directory entry representing the organization with which the person is associated
        'eduPersonOrgDN' =>[
            'fullName' => 'Organization path',
            'oid'      => '1.3.6.1.4.1.5923.1.1.1.3',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonOrgDN',
        ],
        //Organization unit path: The distinguished name (DN) of the directory entries representing the person\'s Organizational Unit(s)
        'eduPersonOrgUnitDN' =>[
            'fullName' => 'Organizational unit path',
            'oid'      => '1.3.6.1.4.1.5923.1.1.1.4',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonOrgUnitDN',
        ],
        //Member of: URI (either URL or URN) that indicates a set of rights to specific resources based on an agreement ac
        'eduPersonEntitlement' =>[
            'fullName' => 'Entitlement',
            'oid'      => '1.3.6.1.4.1.5923.1.1.1.7',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonEntitlement',
        ],
        //Surname or family name
        'surname' =>[
            'fullName' => 'Surname',
            'oid'      => '2.5.4.4',
            'urn'      => 'urn:mace:dir:attribute-def:sn',
        ],
        //Given name of a person
        'givenName' =>[
            'fullName' => 'Given name',
            'oid'      => '2.5.4.42',
            'urn'      => 'urn:mace:dir:attribute-def:givenName',
        ],
        //A unique identifier for a person, mainly used for user identification within the user\'s home organization.
        'uid' =>[
            'fullName' => 'User ID',
            'oid'      => '0.9.2342.19200300.100.1.1',
            'urn'      => 'urn:mace:dir:attribute-def:uid',
        ],
        //Identifies an employee within an organization
        'employeeNumber' =>[
            'fullName' => 'Employee number',
            'oid'      => '2.16.840.1.113730.3.1.3',
            'urn'      => 'urn:mace:dir:attribute-def:employeeNumber',
        ],
        //OrganizationalUnit currently used for faculty membership of staff at UZH.
        'ou' =>[
            'fullName' => 'Organizational Unit',
            'oid'      => '2.5.4.11',
            'urn'      => 'urn:mace:dir:attribute-def:ou',
        ],
        //eduPerson per Internet2 and EDUCAUSE see http://www.nmi-edit.org/eduPerson/draft-internet2-mace
        'eduPersonPrincipalName' =>[
            'fullName' => 'Principal Name',
            'oid'      => '1.3.6.1.4.1.5923.1.1.1.6',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonPrincipalName',
        ],
        //Level that describes the confidences that one can have into the asserted identity of the user.
        'eduPersonAssurance' =>[
            'fullName' => 'Assurance Level',
            'oid'      => '1.3.6.1.4.1.5923.1.1.1.11',
            'urn'      => 'urn:mace:dir:attribute-def:assurance',
        ],
        //The Shibboleth transient ID is a name format that was used to encode eduPersonTargetedID in the past. a limited number of reasources still use this
        'transientId' =>[
            'fullName' => 'transient nameid for backward compatibility',
            'oid'      => '1.2.3.4.5.6.7.8.9.10',
            'urn'      => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
        ],
        //Organization Name
        'organizationName' =>[
            'fullName' => 'Organization Name',
            'oid'      => '2.5.4.10',
            'urn'      => 'urn:mace:dir:attribute-def:o',
        ],
        //A pseudonomynous ID generated by the IdP that is unique to each SP
        'eduPersonTargetedID' =>[
            'fullName' => 'eduPerson Targeted ID',
            'oid'      => '1.3.6.1.4.1.5923.1.1.1.10',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonTargetedID',
        ],
        //This is the Athens persistentUID, it has no OID so we re-use the EduPerson PersistenID OID as it is closest
        'persistentUID' =>[
            'fullName' => 'persistentUID',
            'oid'      => '3.6.1.4.1.5923.1.1.1.10',
            'urn'      => 'urn:mace:eduserv.org.uk:athens:attribute-def:person:1.0:persistentUID',
        ],
        //'the affiliation of the user to the organisation concatendated with the domain name of the org (e.g. staff@tools4schools.ie)'
        'eduPersonScopedAffiliation' =>[
            'fullName' => 'Affiliation (Scoped)',
            'oid'      => '1.3.6.1.4.1.5923.1.1.1.9',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonScopedAffiliation',
        ],
    ]
];