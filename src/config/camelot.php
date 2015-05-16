<?php

return array(



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
        | Detect driver to use
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
        'detect_driver' => true,

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
        | Default Storage Driver
        |--------------------------------------------------------------------------
        |
        | This option controls which Storage driver should be used if
        | none is provided as part of the request
        |
        | Supported by default: "eloquent" download additional packages
        | with drivers to support additional storage methods
        |
        |
        */

        'default_storage_driver' =>'eloquent',



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
            'OneloginIDP'   => array('driver'=>'saml2IDP', 'provider'=>'https://app.onelogin.com/saml/metadata/343584'),
            'OneloginSP'    => array('driver'=>'saml2SP', 'provider'=>'https://app.onelogin.com/saml/metadata/297476'),
            'Salesforce'    => array('driver'=>'saml2SP', 'provider'=>'https://tools4schools-dev-ed.my.salesforce.com'),
            'Openidp'       => array('driver'=>'saml2SP', 'provider'=>'https://openidp.feide.no'),
            'Saml2'         => array('driver'=>'saml2IDP'),
        ),

);
