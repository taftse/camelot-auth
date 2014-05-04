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
    'models' => [
                    'entity'                => ['model'=>'Auth\Saml2\Metadata\Database\Eloquent\Entity', 'table'=>'saml2_entities'],
                    'services'              => ['model'=>'Auth\Saml2\Metadata\Database\Eloquent\Service', 'table'=>'saml2_services'],
                    'certificate'           => ['model'=>'Auth\Saml2\Metadata\Database\Eloquent\Certificate', 'table'=>'saml2_certificates'],
                    'contacts'              => ['model'=>'Auth\Saml2\Metadata\Database\Eloquent\Contact', 'table'=>'saml2_contacts'],
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














	