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



    public function __construct(ConfigInterface $config,SessionInterface $session, $path)
    {
        $this->config = $config;
        $this->session = $session;
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

        return $driver;
    }




    public function __call($method,$parameters)
    {
       return call_user_func(array( $this->driver(),$method),$parameters);
    }

} 