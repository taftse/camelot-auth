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
		'provider_routing' => array('Local' => array('Driver'=>'local'),
								   'Google'=> array('Driver'=>'oauth2'),
                                   'Facebook'=> array('Driver'=>'oauth2'),
                                   'Foursquare' =>array('Driver'=>'oauth2'),
                                   'Windowslive'=>array('Driver'=>'oauth2'),
                                   'Edugate' => array('Driver'=>'saml')
                                   ),



        'login_uri' => 'account/login',



        'registration_uri' => 'account/register',

        'verification_uri' => 'account/verify'




















	);