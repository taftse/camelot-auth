<?php namespace T4s\CamelotAuth;

use T4s\CamelotAuth\Auth;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

class Camelot{

    /**
    * The Session Driver used by Camelot
    *
    * @var use T4s\CamelotAuth\Session\SessionInterface;
    */
    protected $session;

    /**
    * The Cookie Driver used by Camelot
    *
    * @var use T4s\CamelotAuth\Cookie\CookieInterface;
    */
    protected $cookie;

    /**
     * The Database Driver
     *
     * @var T4s\CamelotAuth\Database\DatabaseInterface
     */
    protected $database;

    /**
     * The Config driver
     *
     * @var T4s\CamelotAuth\Config\ConfigInterface
     */
    protected $config;

    /**
     * The Messaging driver
     *
     * @var T4s\CamelotAuth\Messaging\MessagingInterface
     */
    protected $messaging;

    /**
    * The event dispatcher instance.
    *
    * @var T4s\CamelotAuth\Events\DispatcherInterface;
    */
    protected $dispatcher;

    /**
     * A list of supported drivers 
     *
     * @var array
     */
    protected $supported_drivers = array();

    /**
     * The http Path
     *
     * @var string
     */
    protected $path;

    /**
     * Loaded Authentication Driver.
     *
     * @var T4s\CamelotAuth\AuthDriver\CamelotDriver
     */
    protected $driver = null;



    public function __construct(SessionInterface $session,CookieInterface $cookie,ConfigInterface $config,MessagingInterface $messaging,$path)
    {
        $this->session = $session;
        $this->cookie = $cookie;
        $this->config = $config;
        $this->messaging = $messaging;
        $this->path = $path;

        $this->supported_drivers = $this->config->get('camelot.provider_routing'); 

        $this->database = $this->loadDatabaseDriver($this->config->get('camelot.database_driver'));


    }

    public function __call($method,$params)
    { 
        // does this function override the authentication provider
        if(isset($params[0]) && is_string($params[0]) && isset($this->supported_drivers[ucfirst($params[0])]))
        {
            $provider = $params[0];
            // is this authentication provider an alias of another authentication provider
            $provider = $this->checkForAlias($provider);
            // load the driver
            $driver = $this->loadAuthDriver($this->supported_drivers[ucfirst($params[0])]['driver']);

        }

        // no driver is set yet 
        if(!isset($driver) || is_null($driver))
        {
            if(is_null($this->driver))
            {
                $this->driver = $this->detectAuthDriver();
            }

            $driver = $this->driver;
        }

        // now that we have gotten the authentication driver 
        // lets see if the requested method exists 
        if(method_exists($driver,$method))
        {
            // it does so lets call it 
            return call_user_func_array(array($driver,$method),$params);
        }
        else
        {
            // methods not found so throw an error 
            throw new \Exception("the requested function (".$method.") is not available for the requested driver "); 
        }
    }


    protected function loadDatabaseDriver($driverName)
    {
        $databaseDriverClass = 'T4s\CamelotAuth\Database\\'.ucfirst($driverName).'Database';
        return new $databaseDriverClass($this->config);
    }

	

    public function detectAuthDriver()
    {
        // should we detect the authentication driver?
        // if yes, a provider will be set, otherwise the provider will be null
        $provider = $this->detectProviderFromSegments();
        // if the provider exists, the driverName will be set correctly
        // if not, the driverName will be set to null
        $driverName = $this->getDriver($provider);

        // if the driver is still null lets just give up and load the default provider no one will know
        if(!isset($driverName))
        {
            $provider = $this->config->get('camelot.default_provider');
            $driverName = $this->getDriver($provider);
        }

         // is this authentication provider an alias of another authentication provider
        $provider = $this->checkForAlias($provider);

        return $this->loadAuthDriver($driverName,$provider);
    }
    
    public function detectProviderFromSegments()
    {
	    if($this->config->get('camelot.detect_provider'))
        {
            $segments = explode("/", $this->path);
			$segmentNr = $this->config->get('camelot.route_location');
            if(isset($segments[$segmentNr-1]))
            {
                return $provider = ucfirst($segments[$segmentNr-1]);
            }
        }
        return null;

    }
    
    public function checkForAlias($provider){
		if(isset($this->supported_drivers[ucfirst($provider)]['provider'] )) 
        {
        	$aliased = $this->supported_drivers[ucfirst($provider)]['provider'];
            $aliased = $this->checkForAlias($aliased);
            return $aliased;
        }
        return $provider;		    
    }
    
    public function getDriver($provider = null)
    {
	    if(isset($this->supported_drivers[ucfirst($provider)]))
        {
        	return $this->supported_drivers[ucfirst($provider)]['driver'];
        }
        return null;
    }


    public function loadAuthDriver($driverName = null,$provider = null)
    {
        // lets load the specified driver file
        $driverFile = __DIR__.'/Auth/'.ucfirst($driverName).'Auth.php';
        if(!file_exists($driverFile))
        {
            throw new \Exception("Cannot Find the ".ucfirst($driverName)." Driver");
        }
        include_once $driverFile;

        // lets check that the driver class exists
        $driverClass ='T4s\CamelotAuth\Auth\\'.ucfirst($driverName).'Auth';
        if(!class_exists($driverClass,false))
        {
            throw new \Exception("Cannot Find Driver class (".$driverClass.")");
        }

        $this->driver = new $driverClass(
            $provider,
            $this->config,
            $this->session,
            $this->cookie,
            $this->database,
            $this->messaging,
            $this->path
            );

        if(isset($this->dispatcher))
        {
            $this->driver->setEventDispatcher($this->dispatcher);
        }

        return $this->driver;
    }


    /**
    * Get the event dispatcher instance.
    *
    * @return T4s\CamelotAuth\Events\DispatcherInterface
    */
    public function getEventDispatcher()
    {
         if(!is_null($this->driver))
         {
            return $this->driver->getEventDispatcher();
         }   
        return $this->dispatcher;
    }

    /**
    * Set the event dispatcher instance.
    *
    * @param T4s\CamelotAuth\Events\DispatcherInterface
    */
    public function setEventDispatcher(DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        if(!is_null($this->driver))
         {
            return $this->driver->setEventDispatcher($dispatcher);
         }  
    }

}