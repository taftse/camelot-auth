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

        'model' => 'T4s\CamelotAuth\Models\Eloquent\Account',


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
        'default_provider' => 'local',

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
               // 'Saml'          => array('driver'=>'saml2SP'),
                'OneloginIDP'      => array('driver'=>'saml2IDP', 'provider'=>'https://app.onelogin.com/saml/metadata/343584'),
                'OneloginSP'      => array('driver'=>'saml2SP', 'provider'=>'https://app.onelogin.com/saml/metadata/297476'),
                'Salesforce'    => array('driver'=>'saml2SP', 'provider'=>'https://tools4schools-dev-ed.my.salesforce.com'),
                'Openidp'       => array('driver'=>'saml2SP', 'provider'=>'https://openidp.feide.no'),
                'Saml2'         => array('driver'=>'saml2IDP'),
             ),


        /*
        |----------------------------------------------------------------------------
        | Required Registration fields
        |----------------------------------------------------------------------------
        |
        | This option allows you to specify the Account details required 
        | to complete an account registration 
        |
        | uncomment any required attributes 
        */

        'required_account_details' =>array(
                'first_name',
                'last_name',
                'email',
                //'address_1',
                //'address_2',  // address 2 is optional 
                //'city',
                //'zip_code',   // not all countries have zip codes
                //'state',
                //'country_iso',
                //'dob',        // date of birth
                //'phone',
                //'gender',
            ),

    'login_uri' => '',
    
    'registration_uri' => 'account/register',
    'verification_uri' => 'account/verify',
);
