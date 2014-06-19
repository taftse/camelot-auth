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
    'models' => [
                    'entity'                => 'Auth\Saml2\Metadata\Storage\Eloquent\Entity',
                    'services'              => 'Auth\Saml2\Metadata\Storage\Eloquent\Service',
                    'certificate'           => 'Auth\Saml2\Metadata\Storage\Eloquent\Certificate',
                    'contacts'              => 'Auth\Saml2\Metadata\Storage\Eloquent\Contact',
                ],



    'tables' => [
                    'entity'                => 'saml2_entities',
                    'serviceLocation'       => 'saml2_services',
                    'certificate'           => 'saml2_certificates',
                    'contacts'              => 'saml2_contacts',
    ],


	);














	