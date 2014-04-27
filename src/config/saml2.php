<?php

return array(
	/*
    |--------------------------------------------------------------------------
    | Default Metadata Storage
    |--------------------------------------------------------------------------
    |
    | This option controls where the metadata will be stored 
    |
    | Supported: "database", "config"
    |
    */
	'metadataStore' => 'database',


    'myEntityID' => 'https://idp.tools4schools.org',

    /**
     *  what tables/models should be used
     *
     * uncomment which one will bu used
     */

    // eloquent
    ///*
    'tables' => [
                    'entity'                => 'Saml2\Metadata\Database\Eloquent\Entity',
                    'serviceLocation'       => 'Saml2\Metadata\Database\Eloquent\ServiceLocation',
                    'certificate'           => 'Saml2\Metadata\Database\Eloquent\Certificate',
                    'contacts'              => 'Saml2\Metadata\Database\Eloquent\Contact',
                ],
    //*/

    /*
    'tables' => [
        'entity'                => 'saml2_entities',
        'serviceLocation'       => 'saml2_service_locations',
        'certificate'           => 'saml2_certificates',
        'contacts'              => 'saml2_contacts',
    ],
    //*/

	);














	