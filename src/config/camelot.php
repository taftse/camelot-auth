<?php 

return array(
        /*
        |--------------------------------------------------------------------------
        | Default Database Driver
        |--------------------------------------------------------------------------
        |
        | This option controls the database driver that will be utilized.
        | This drivers manages the retrieval of the users details
        |
        | Supported: "database", "eloquent"
        |
        */

        'database_driver' => 'eloquent',

        /*
        |--------------------------------------------------------------------------
        | Authentication Model
        |--------------------------------------------------------------------------
        |
        | When using the "Eloquent" authentication driver, we need to know which
        | Eloquent model should be used to retrieve your users.
        |
        */

        'model' => 'CamelotUser',


		/*
		|--------------------------------------------------------------------------
		| Default Authentication Driver
		|--------------------------------------------------------------------------
		|
		| This option controls which authentication driver should be used if 
		| none is provided as part of the url 
		|
		| Supported by default: "local" download aditional packages 
		| with drivers to support aditional authentication methods 
		|
		|
		*/
		'default_driver' => 'local',

        /*
        |--------------------------------------------------------------------------
        | Detect provider to use
        |--------------------------------------------------------------------------
        |
        | This option controls whether we should try to detect what authentication 
        | driver should be used
        |
        | if this value is set to false and Camelot:loadDriver('Driver'); has not been run
        | it will then load the default_driver value
        |
        |
        */
        'detect_provider' => true,

        /*
        |--------------------------------------------------------------------------
        | URI to Route
        |--------------------------------------------------------------------------
        |
        | This option controls which uri segment specifies the authentication provider
        |
        | if no matching provider_route is found 
        | it will load the default_driver value
        |
        |
        */
        'route_location' => 2,

        /*
        |--------------------------------------------------------------------------
        | Route to Driver 
        |--------------------------------------------------------------------------
        |
        | This option controls which authentication driver should be called
        | by which uri segment
        |
        | if the route is not provided in this array 
        | it will load the default_driver value
        |
        |
        */
		'provider_routing' => array('Local' => array('driver'=>'local',
                                        'config' => array(
                                            'userIdentifierField'=>'',
                                            'userPasswordField'=>'',
                                            'loginSubmitField'=>'',
                                            )),
								    'Google'=> array('driver'=>'Oauth2Client',
                                        'config'=>array(
                                            'clientID' =>'881575521529-nnatthifivm2nak2il49c4srdm6kr27r.apps.googleusercontent.com',
                                            'clientSecret' =>'uDcpbc040zJsNFYgmRfJTa3i',
                                            'forceApproval' =>false,
                                            'scopes' => array(
                                                // Userinfo - Email
                                                'https://www.googleapis.com/auth/userinfo.email',
                                                // Userinfo - Profile
                                                'https://www.googleapis.com/auth/userinfo.profile',  
                                                // Adsense Management
                             //                   'https://www.googleapis.com/auth/adsense',
                                                // Google Affiliate Network
                             //                   'https://www.googleapis.com/auth/gan',
                                                // Analytics
                             //                   'https://www.googleapis.com/auth/analytics.readonly',
                                                // Google Books
                             //                   'https://www.googleapis.com/auth/books',
                                                // Blogger
                             //                  'https://www.googleapis.com/auth/blogger',
                                                // Calendar
                             //                   'https://www.googleapis.com/auth/calendar',
                                                // Google Cloud Storage
                             //                   'https://www.googleapis.com/auth/devstorage.read_write',
                                                // Contacts
                             //                   'https://www.google.com/m8/feeds/',
                                                // Content API for Shopping
                             //                   'https://www.googleapis.com/auth/structuredcontent',
                                                // Chrome Web Store
                             //                   'https://www.googleapis.com/auth/chromewebstore.readonly',
                                                // Documents List
                             //                   'https://docs.google.com/feeds/',
                                                // Google Drive
                             //                   'https://www.googleapis.com/auth/drive.file',
                                                // Gmail
                             //                   'https://mail.google.com/mail/feed/atom',
                                                // Google+
                             //                   'https://www.googleapis.com/auth/plus.me',
                                                // Groups Provisioning
                             //                   'https://apps-apis.google.com/a/feeds/groups/',
                                                // Google Latitude
                             //                   'https://www.googleapis.com/auth/latitude.all.best',
                             //                   'https://www.googleapis.com/auth/latitude.all.city',
                                                // Moderator
                             //                   'https://www.googleapis.com/auth/moderator',
                                                // Nicknames Provisioning
                             //                   'https://apps-apis.google.com/a/feeds/alias/',
                                                // Orkut
                             //                   'https://www.googleapis.com/auth/orkut',
                                                // Picasa Web
                             //                   'https://picasaweb.google.com/data/',
                                                // Sites
                             //                   'https://sites.google.com/feeds/',
                                                // Spreadsheets
                             //                   'https://spreadsheets.google.com/feeds/',
                                                // Tasks
                             //                   'https://www.googleapis.com/auth/tasks',
                                                // URL Shortener
                             //                   'https://www.googleapis.com/auth/urlshortener',
                                                // User Provisioning
                             //                   'https://apps-apis.google.com/a/feeds/user/',
                                                // Webmaster Tools
                             //                   'https://www.google.com/webmasters/tools/feeds/',
                                                // YouTube
                             //                   'https://gdata.youtube.com',
                                                            ))),
                                    'Facebook'=> array('driver'=>'oauth2Client',
                                        'config'=>array(
                                            'clientID' =>'340444932663232',
                                            'clientSecret' =>'3688b13e32bfd060f3bea409a421eb5f',
                                            'scopes' => array(
                                                'offline_access', 
                                                'email', 
                                                'read_stream',
                                                'user_birthday'
                                                             ))),
                                    'Foursquare' =>array('driver'=>'oauth2Client',
                                        'config'=>array(
                                            'clientID' =>'',
                                            'clientSecret' =>'',
                                            'scopes' => array()
                                                        )),
                                    'Windowslive'=>array('driver'=>'oauth2Client',
                                        'config'=>array(
                                            'clientID' =>'',
                                            'clientSecret' =>'',
                                            'grantType' =>'',
                                            'scopes' => array()
                                                        )),
                                    'Github'=>array('driver'=>'oauth2Client',
                                        'config'=>array(
                                            'clientID'=>'6e5f2f14f7c8e0366331',
                                            'clientSecret'=>'50b37d9edf4da371f35a329fca8fa3ece2a48e14',
                                            'scopes' => array('user')
                                                        )),
                                    'Edugate' => array('driver'=>'saml'),
                                    ),
               

        'account_requirements' => array('table_field_name'=>array('form_field_name'=>'rule'),
                                        'table_field_name'=>array('form_field_name'=>'rule'),
                                       ),



        'login_uri' => 'account/login',



        'registration_uri' => 'account/register',

        'verification_uri' => 'account/verify',

	);