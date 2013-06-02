<?php namespace TwswebInt\CamelotAuth;

use TwswebInt\CamelotAuth\Auth;
use TwswebInt\CamelotAuth\Database\DatabaseInterface;
use TwswebInt\CamelotAuth\Session\SessionInterface;
use TwswebInt\CamelotAuth\Cookie\CookieInterface;
use TwswebInt\CamelotAuth\Events\DispatcherInterface;

class Camelot{

    /**
    * The Session Driver used by Camelot
    *
    * @var use TwswebInt\CamelotAuth\Session\SessionInterface;
    */
    protected $session;

    /**
    * The Cookie Driver used by Camelot
    *
    * @var use TwswebInt\CamelotAuth\Cookie\CookieInterface;
    */
    protected $cookie;

    /**
     * The Database Driver
     *
     * @var TwswebInt\CamelotAuth\Database\DatabaseInterface
     */
    protected $database;

    /**
     * A Array Containing the cammelot settings
     *
     */
    protected $config;

    /**
    * The event dispatcher instance.
    *
    * @var TwswebInt\CamelotAuth\Events\DispatcherInterface;
    */
    protected $events;

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
    protected $httpPath;

    /**
     * Loaded Authentication Driver.
     *
     * @var TwswebInt\CamelotAuth\AuthDriver\CamelotDriver
     */
    protected $driver = null;


    public function __construct(SessionInterface $session,CookieInterface $cookie,array $config,$httpPath)
    {
        $this->session = $session;
        $this->cookie = $cookie;
        $this->config = $config;
        $this->httpPath = $httpPath;
        $this->supported_drivers = $config['provider_routing'];   

        $this->session->put($this->session->get('current_url'),'previous_url');
        $this->session->put($this->httpPath,'current_url');    
    }

    public function loadDriver($driverName = null,$provider = null)
    {
        // there is no driver specified lets try and detect the required driver
        if(is_null($driverName))
        {
            // if detect_provider == true 
            if($this->config['detect_provider'])
            {
                $segments = explode("/", $this->httpPath);

                if(isset($segments[$this->config['route_location']-1]))
                {
                    $provider = $segments[$this->config['route_location']-1];
               
                    if(isset($this->supported_drivers[ucfirst($provider)]))
                    {
                       $driverName = $this->supported_drivers[ucfirst($provider)]['driver'];
                    }
                }
            }

            // if the driver is still null lets just load the default driver
            if(is_null($driverName))
            {
                $driverName = $this->config['default_driver'];
            }
        }
        
        // lets load the specified driver
        $driverFile = __DIR__.'/Auth/'.ucfirst($driverName).'Auth.php';
        if(!file_exists($driverFile))
        {
            throw new \Exception("Cannot Find the ".ucfirst($driverName)." Driver");
        }
        include_once $driverFile;
        
        $driverClass ='TwswebInt\CamelotAuth\Auth\\'.ucfirst($driverName).'Auth';
        if(!class_exists($driverClass,false))
        {
            throw new \Exception("Cannot Find Driver class (".$driverClass.")");
        }
        // are there config settings set for this driver if not set it to blank
        if(!isset($this->supported_drivers[ucfirst($provider)]['config']))
        {
            $this->config['provider_routing'][ucfirst($provider)]['config'] = array();
        }

        $databaseDriver = $this->loadDatabaseDriver(ucfirst($driverName));
        return new $driverClass(
                $this->session,
                $this->cookie,
                $databaseDriver,
                $provider,
                $this->config,
                $this->httpPath
                );
    }

    public function __call($method,$params)
    {      
        if(isset($params[0]) && is_string($params[0]) && isset($this->supported_drivers[ucfirst($params[0])]))
        {                
                $driver = $this->loadDriver($this->supported_drivers[ucfirst($params[0])]['driver']);
                echo $params[0];
        }

        if(!isset($driver) || is_null($driver)) 
        {
            if(is_null($this->driver))
            {
               $this->driver = $this->loadDriver();             
            }  
             $driver = $this->driver;
        }
     
        if(method_exists($driver,$method))
        {
            return call_user_func_array(array($driver,$method), $params);
        }
    	else
        {
            throw new \Exception("the requested function (".$method.") is not available for the requested driver ");         
        }
    }

   protected function loadDatabaseDriver($authDriverName){

       $driverName = $this->config['database_driver'];
       $databaseDriverClass = 'TwswebInt\CamelotAuth\Database\\'.ucfirst($driverName).'Database';
       return new $databaseDriverClass($authDriverName);
   }

    /**
    * Get the event dispatcher instance.
    *
    * @return TwswebInt\CamelotAuth\Events\DispatcherInterface
    */
    public function getEventDispatcher()
    {
         if(!is_null($this->driver))
         {
            return $this->driver->getEventDispatcher();
         }   
        return $this->events;
    }

    /**
    * Set the event dispatcher instance.
    *
    * @param TwswebInt\CamelotAuth\Events\DispatcherInterface
    */
    public function setEventDispatcher(DispatcherInterface $events)
    {
        $this->events = $events;
        if(!is_null($this->driver))
         {
            return $this->driver->setEventDispatcher($events);
         }  
    }

}