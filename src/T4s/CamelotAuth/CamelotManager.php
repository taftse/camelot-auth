<?php namespace T4s\CamelotAuth;
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
*/



use Closure;
use InvalidArgumentException;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;

class CamelotManager {

    /**
     * The Config driver
     *
     * @var T4s\CamelotAuth\Config\ConfigInterface
     */
    protected $config;

    /**
     * The Session Driver used by Camelot
     *
     * @var T4s\CamelotAuth\Session\SessionInterface;
     */
    protected $session;


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

    /**
     * the authentication provider handling the request
     * @var
     */
    protected $provider;

    public function __construct(ConfigInterface $config,SessionInterface $session, $path)
    {
        $this->config = $config;
        $this->session = $session;
        $this->path = $path;
        //$this->storage = $this->loadStorageDriver();
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
            $this->drivers[$driver] = $this->loadDriver($driver);
        }

        return $this->drivers[$driver];
    }


    protected function detectDriver()
    {
        $segments = explode("/", $this->path);
        $segmentNr = $this->config->get('camelot.route_location');

        if(isset($segments[$segmentNr-1]))
        {
            $this->provider = ucfirst($segments[$segmentNr-1]);

            if(isset($this->config->get('camelot.provider_routing')[ucfirst($this->provider)]))
            {
                return $this->config->get('camelot.provider_routing')[ucfirst($this->provider)]['driver'];
            }
        }

        return null;
    }

    /**
     * Call a custom driver creator.
     *
     * @param  string  $driver
     * @return mixed
     */
    protected function callCustomCreator($driver)
    {
        return $this->customCreators[$driver]($this->config,$this->session,$this->cookie,$this->path);
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

        $driverClass ='T4s\CamelotAuth\Auth\\'.$driverName.'\\'.$driverName.'Driver';

        if(!class_exists($driverClass))
        {
            throw new InvalidArgumentException("Driver [$driverName] not supported.");
        }

        $driver = new $driverClass(
            $this->config,
            $this->session
        );

        $driver->setProvider($this->provider);

        return $driver;
    }

    public function __call($method,$parameters)
    {
        // lets see if the requested method exists
        if(method_exists($this->driver(),$method))
        {
            return call_user_func_array(array( $this->driver(),$method),$parameters);
        }

        throw new InvalidArgumentException("Driver does not support method call ".$method);
    }

} 