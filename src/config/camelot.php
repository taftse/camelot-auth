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
        | Supported: "database", "Eloquent"
        |
        */

        'database_driver' => 'Eloquent',

        /*
        |--------------------------------------------------------------------------
        | Authentication Model
        |--------------------------------------------------------------------------
        |
        | When using the "Eloquent" authentication driver, we need to know which
        | Eloquent model should be used to retrieve your users.
        |
        */

        'model' => 'Account',


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
        | Default registration account status
        |--------------------------------------------------------------------------
        |
        | This option controls whether the account is active or pending
        |
        | if this value is set to pending then the user can not logon untill the  
        | acount is activated
        |
        */

        'default_status' =>'pending',

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
        |-------------------------------------------------------------------------
        | Redirect To Route
        |-------------------------------------------------------------------------
        |
        | This option controlls where a user is sent after successfull login if no
        | destination route is provided
        |
        |
        */
        'login_success_route' => 'dashboard',

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


        'provider_routing'  => array(
                'Local'         => array('driver'=>'local'),
                'Google'        => array('driver'=>'Oauth2Client'),
                'Youtube'       => array('driver'=>'Oauth2Client','provider'=>'Google'),
                'Facebook'      => array('driver'=>'oauth2Client'),
                'Foursquare'    => array('driver'=>'oauth2Client'),
                'Windowslive'   => array('driver'=>'oauth2Client'),
                'Github'        => array('driver'=>'oauth2Client'),
                'Linkedin'      => array('driver'=>'oauth2Client'),
                'Twitter'       => array('driver'=>'oauth1Client'),
                'Edugate'       => array('driver'=>'saml'),
             ),


/*

        'provider_routing' => array('Local' => array('driver'=>'local',
            'config' => array(
                'hasher'=>'Bcrypt',
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
                    // 'https://www.googleapis.com/auth/adsense',
                    // Google Affiliate Network
                    // 'https://www.googleapis.com/auth/gan',
                    // Analytics
                    // 'https://www.googleapis.com/auth/analytics.readonly',
                    // Google Books
                    // 'https://www.googleapis.com/auth/books',
                    // Blogger
                    // 'https://www.googleapis.com/auth/blogger',
                    // Calendar
                    // 'https://www.googleapis.com/auth/calendar',
                    // Google Cloud Storage
                    // 'https://www.googleapis.com/auth/devstorage.read_write',
                    // Contacts
                    // 'https://www.google.com/m8/feeds/',
                    // Content API for Shopping
                    // 'https://www.googleapis.com/auth/structuredcontent',
                    // Chrome Web Store
                    // 'https://www.googleapis.com/auth/chromewebstore.readonly',
                    // Documents List
                    // 'https://docs.google.com/feeds/',
                    // Google Drive
                    // 'https://www.googleapis.com/auth/drive.file',
                    // Gmail
                    // 'https://mail.google.com/mail/feed/atom',
                    // Google+
                    // 'https://www.googleapis.com/auth/plus.me',
                    // Groups Provisioning
                    // 'https://apps-apis.google.com/a/feeds/groups/',
                    // Google Latitude
                    // 'https://www.googleapis.com/auth/latitude.all.best',
                    // 'https://www.googleapis.com/auth/latitude.all.city',
                    // Moderator
                    // 'https://www.googleapis.com/auth/moderator',
                    // Nicknames Provisioning
                    // 'https://apps-apis.google.com/a/feeds/alias/',
                    // Orkut
                    // 'https://www.googleapis.com/auth/orkut',
                    // Picasa Web
                    // 'https://picasaweb.google.com/data/',
                    // Sites
                    // 'https://sites.google.com/feeds/',
                    // Spreadsheets
                    // 'https://spreadsheets.google.com/feeds/',
                    // Tasks
                    // 'https://www.googleapis.com/auth/tasks',
                    // URL Shortener
                    // 'https://www.googleapis.com/auth/urlshortener',
                    // User Provisioning
                    // 'https://apps-apis.google.com/a/feeds/user/',
                    // Webmaster Tools
                    // 'https://www.google.com/webmasters/tools/feeds/',
                    // YouTube
                    // 'https://gdata.youtube.com',
                )
            )
        ),
        'Facebook'=> array('driver'=>'oauth2Client',
            'config'=>array(
                'clientID' =>'340444932663232',
                'clientSecret' =>'3688b13e32bfd060f3bea409a421eb5f',
                'scopes' => array(
                    'offline_access',
                    'email',
                    'read_stream',
                    'user_birthday'
                )
            )
        ),
        'Foursquare' =>array('driver'=>'oauth2Client',
            'config'=>array(
                'clientID' =>'VPFG500ZMZ4LVBXRYLFOKDB42ADM1EESBFURU1EGH3V55VBM',
                'clientSecret' =>'GP1TR12RWHJTLSUFZYJMIBSZIBAXQKQQMYV3VUGP1IQC3VZW',
                'scopes' => array()
            )
        ),
        'Windowslive'=>array('driver'=>'oauth2Client',
            'config'=>array(
                'clientID' =>'000000004C0F7A4B',
                'clientSecret' =>'7qMsA2vrp8cUm1LN4k9UupzWsTxsEven',
                'scopes' => array(
                    'wl.basic',
                    'wl.emails',
                    'wl.signin'
                )
            )
        ),
        'Github'=>array('driver'=>'oauth2Client',
            'config'=>array(
                'clientID'=>'6e5f2f14f7c8e0366331',
                'clientSecret'=>'50b37d9edf4da371f35a329fca8fa3ece2a48e14',
                'scopes' => array('user')
            )
        ),
        'Twitter'=>array('driver'=>'oauth1Client',
            'config'=>array(
                'clientID'=>'zBW0Sz2bgVgswo0GKO7rMA',
                'clientSecret'=>'aVvEp0gqDXrnNBEV0XjmHOKedHk1qgstXWmVSYe7o',
                'signature'=>'HMAC-SHA1',
                'scopes' => array('user')
            )
        ),
        'Linkedin'=> array('driver' =>'oauth2Client',
            'config'=> array(
                'clientID' =>'d0utnde98m9i',
                'clientSecret'=>'5jZ2OijrqhMvscNM',
                'scopes'=> array(
                   /* 'r_basicprofile',
                    'r_emailaddress',
                    'r_contactinfo'*/
             /*       )
                )
            ),
        'Edugate' => array('driver'=>'saml'),
    ),

*/
    'login_uri' => 'login',
    'registration_uri' => 'account/register',
    'verification_uri' => 'account/verify',
);
