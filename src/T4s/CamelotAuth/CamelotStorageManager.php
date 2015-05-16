<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth;


use T4s\CamelotAuth\Config\ConfigInterface;

class CamelotStorageManager {

    /**
     * The Config driver
     *
     * @var T4s\CamelotAuth\Config\ConfigInterface
     */
    protected $config;

    /**
     * Loaded Authentication Drivers.
     *
     * @var array
     */
    protected $drivers = array();

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = array();


    public function __construct(ConfigInterface $config, $driver = null)
    {
        $this->config = $config;
        $this->driver($driver);
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
           $driver = $this->config->get('camelot.default_driver');
        }

        if(! isset($this->drivers[$driver]))
        {
            $this->drivers[$driver] = $this->loadDriver($driver);
        }

        return $this->drivers[$driver];
    }

    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */

    protected function loadDriver($driverName)
    {
        if(isset($this->customCreators[$driverName]))
        {
            return $this->callCustomCreator($driverName);
        }

        $driverClass ='T4s\CamelotAuth\Storage\\'.$driverName.'\\'.$driverName.'Driver';

        if(!class_exists($driverClass))
        {
            throw new \InvalidArgumentException("Driver [$driverName] not supported.");
        }

        $driver = new $driverClass(
            $this->config
        );

        return $driver;
    }
} 