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
            'oid'      => 'urn:oid:2.16.840.1.113730.3.1.39',
            'urn'      => 'urn:mace:dir:attribute-def:preferredLanguage',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:basic',
        ],
        //E-Mail: Preferred address for e-mail to be sent to this person
        'mail' =>[
            'fullName' => 'Email',
            'oid'      => 'urn:oid:0.9.2342.19200300.100.1.3',
            'urn'      => 'urn:mace:dir:attribute-def:mail',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //Home postal address: Home address of the user
        'homePostalAddress' =>[
            'fullName' => 'Home postal address',
            'oid'      => 'urn:oid:0.9.2342.19200300.100.1.39',
            'urn'      => 'urn:mace:dir:attribute-def:homePostalAddress',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //Business postal address: Campus or office address
        'postalAddress' =>[
            'fullName' => 'Business postal address',
            'oid'      => 'urn:oid:2.5.4.16',
            'urn'      => 'urn:mace:dir:attribute-def:postalAddress',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:basic',
        ],
        //Private phone number
        'homePhone' =>[
            'fullName' => 'Private phone number',
            'oid'      => 'urn:oid:0.9.2342.19200300.100.1.20',
            'urn'      => 'urn:mace:dir:attribute-def:homePhone',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:basic',
        ],
        //Business phone number: Office or campus phone number
        'telephoneNumber' =>[
            'fullName' => 'Business phone number',
            'oid'      => 'urn:oid:2.5.4.20',
            'urn'      => 'urn:mace:dir:attribute-def:telephoneNumber',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:basic',
        ],
        //Mobile phone number
        'mobile' =>[
            'fullName' => 'Mobile phone number',
            'oid'      => 'urn:oid:0.9.2342.19200300.100.1.41',
            'urn'      => 'urn:mace:dir:attribute-def:mobile',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:basic',
        ],
        //Affiliation: Type of affiliation with Home Organization
        'eduPersonAffiliation' =>[
            'fullName' => 'Affiliation',
            'oid'      => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.1',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonAffiliation',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //Organization path: The distinguished name (DN) of the directory entry representing the organization with which the person is associated
        'eduPersonOrgDN' =>[
            'fullName' => 'Organization path',
            'oid'      => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.3',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonOrgDN',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //Organization unit path: The distinguished name (DN) of the directory entries representing the person\'s Organizational Unit(s)
        'eduPersonOrgUnitDN' =>[
            'fullName' => 'Organizational unit path',
            'oid'      => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.4',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonOrgUnitDN',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //Member of: URI (either URL or URN) that indicates a set of rights to specific resources based on an agreement ac
        'eduPersonEntitlement' =>[
            'fullName' => 'Entitlement',
            'oid'      => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.7',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonEntitlement',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //Surname or family name
        'surname' =>[
            'fullName' => 'Surname',
            'oid'      => 'urn:oid:2.5.4.4',
            'urn'      => 'urn:mace:dir:attribute-def:sn',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:basic',
        ],
        //Given name of a person
        'givenName' =>[
            'fullName' => 'Given name',
            'oid'      => 'urn:oid:2.5.4.42',
            'urn'      => 'urn:mace:dir:attribute-def:givenName',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //A unique identifier for a person, mainly used for user identification within the user\'s home organization.
        'uid' =>[
            'fullName' => 'User ID',
            'oid'      => 'urn:oid:0.9.2342.19200300.100.1.1',
            'urn'      => 'urn:mace:dir:attribute-def:uid',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //Identifies an employee within an organization
        'employeeNumber' =>[
            'fullName' => 'Employee number',
            'oid'      => 'urn:oid:2.16.840.1.113730.3.1.3',
            'urn'      => 'urn:mace:dir:attribute-def:employeeNumber',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //OrganizationalUnit currently used for faculty membership of staff at UZH.
        'ou' =>[
            'fullName' => 'Organizational Unit',
            'oid'      => 'urn:oid:2.5.4.11',
            'urn'      => 'urn:mace:dir:attribute-def:ou',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //eduPerson per Internet2 and EDUCAUSE see http://www.nmi-edit.org/eduPerson/draft-internet2-mace
        'eduPersonPrincipalName' =>[
            'fullName' => 'Principal Name',
            'oid'      => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.6',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonPrincipalName',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //Level that describes the confidences that one can have into the asserted identity of the user.
        'eduPersonAssurance' =>[
            'fullName' => 'Assurance Level',
            'oid'      => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.11',
            'urn'      => 'urn:mace:dir:attribute-def:assurance',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //The Shibboleth transient ID is a name format that was used to encode eduPersonTargetedID in the past. a limited number of reasources still use this
        'transientId' =>[
            'fullName' => 'transient nameid for backward compatibility',
            'oid'      => 'urn:oid:1.2.3.4.5.6.7.8.9.10',
            'urn'      => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //Organization Name
        'organizationName' =>[
            'fullName' => 'Organization Name',
            'oid'      => 'urn:oid:2.5.4.10',
            'urn'      => 'urn:mace:dir:attribute-def:o',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //A pseudonomynous ID generated by the IdP that is unique to each SP
        'eduPersonTargetedID' =>[
            'fullName' => 'eduPerson Targeted ID',
            'oid'      => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.10',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonTargetedID',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //This is the Athens persistentUID, it has no OID so we re-use the EduPerson PersistenID OID as it is closest
        'persistentUID' =>[
            'fullName' => 'persistentUID',
            'oid'      => 'urn:oid:3.6.1.4.1.5923.1.1.1.10',
            'urn'      => 'urn:mace:eduserv.org.uk:athens:attribute-def:person:1.0:persistentUID',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
        //'the affiliation of the user to the organisation concatendated with the domain name of the org (e.g. staff@tools4schools.ie)'
        'eduPersonScopedAffiliation' =>[
            'fullName' => 'Affiliation (Scoped)',
            'oid'      => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.9',
            'urn'      => 'urn:mace:dir:attribute-def:eduPersonScopedAffiliation',
            'format'   => 'urn:oasis:names:tc:SAML:2.0:attribute-format:uri',
        ],
    ]
];