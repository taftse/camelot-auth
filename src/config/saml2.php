<?php

return [
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
	'metadataStore' => 'config',//'database',


    'myEntityID' => 'https://dashboard.pay4school.local',


    'assertionLifetime' => 300,
    /**
     *  what tables/models should be used
     *
     * uncomment which one will bu used
     */

    // eloquent
    'models' => [
                    'entity'                => ['model' => 'Saml2\Entity',      'table' => 'saml2_entities'],
                    'services'              => ['model' => 'Saml2\Service',     'table' => 'saml2_services'],
                    'certificate'           => ['model' => 'Saml2\Certificate', 'table' => 'saml2_certificates'],
                    'contacts'              => ['model' => 'Saml2\Contact',     'table' => 'saml2_contacts'],
                    'saml2user'             => ['model' => 'Saml2\User',        'table' => 'saml2_users'],
                ],



  /*  'tables' => [
                    'entity'                => ,
                    'serviceLocation'       => 'saml2_services',
                    'certificate'           => 'saml2_certificates',
                    'contacts'              => 'saml2_contacts',
    ],
*/

    'certificate' => [
        'public'    => '',
        'private'   => '',
    ],

    // this links saml attributes to the data providers
    'attributes' => [
                        //email
                        'mail'      => ['source' => 'storage', 'model'=>'account', 'field'=>'email'],
                        //surname
                        'surname'   => ['source' => 'storage', 'model'=>'account', 'field'=>'last_name'],
                        //givenName
                        'givenName' => ['source' => 'storage', 'model'=>'account', 'field'=>'first_name'],
                        //
                        ''
        ],

    'authsources' =>[
            'storage' => [

            ],
            'config' => [
                'file' =>''
            ]
        ],
	];














	