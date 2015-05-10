<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\src\T4s\CamelotAuth;


class CamelotManager {


    protected $config;


    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = array();

    /**
     * Loaded Authentication Drivers.
     *
     * @var array
     */
    protected $drivers = array();

    /**
     * The http Path
     *
     * @var string
     */
    protected $path;



    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function driver($driver = null)
    {
        if($driver == null)
        {
            if($this->config->get('camelot.detect_driver') == true)
            {
                $driver = $this->detectDriver();
            }
            if($driver == null)
            {
                $driver = $this->config->get('camelot.default_driver');
            }
        }

        if(! isset($this->drivers[$driver]))
        {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }


    protected function detectDriver()
    {
        $segments = explode("/", $this->path);
        $segmentNr = $this->config->get('camelot.route_location');

        if(isset($segments[$segmentNr-1]))
        {
            $provider = ucfirst($segments[$segmentNr-1]);

            if(isset($this->config->get('camelot.provider_routing')[ucfirst($provider)]))
            {
                return $this->config->get('camelot.provider_routing')[ucfirst($provider)]['driver'];
            }
        }



        return null;
    }


    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */

    protected function createDriver($driver)
    {
        $method = 'create'.ucfirst($driver).'Driver';

    }


    public function __call($method,$parameters)
    {
       return call_user_func(array( $this->driver(),$method),$parameters);
    }

} 