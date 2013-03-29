<?php namespace TwswebInt\CamelotAuth;

use TwswebInt\CamelotAuth\AuthDrivers;
use TwswebInt\ICamelotAuth\Database\DatabaseInterface;
use TwswebInt\CamelotAuth\Session\SessionInterface;
use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;

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
    * @var use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
    */
    protected $cookie;

    /**
     * The Database Driver
     *
     * @var TwswebInt\ICamelotAuth\Database\DatabaseInterface
     */
    protected $database;

    /**
     * A Array Containing the cammelot settings
     *
     */
    protected $config;

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


    public function __construct(SessionInterface $session,CookieDriverInterface $cookie,array $config,$httpPath)
    {
        $this->session = $session;
        $this->cookie = $cookie;
        $this->config = $config;
        $this->httpPath = $httpPath;
        $this->supported_drivers = $config['provider_routing'];       
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
        $driverFile = __DIR__.'/AuthDrivers/'.ucfirst($driverName).'AuthDriver.php';
        if(!file_exists($driverFile))
        {
            throw new \Exception("Cannot Find the ".ucfirst($driverName)." Driver");
        }
        include_once $driverFile;
        
        $driverClass ='TwswebInt\CamelotAuth\AuthDrivers\\'.ucfirst($driverName).'AuthDriver';
        if(!class_exists($driverClass,false))
        {
            throw new \Exception("Cannot Find Driver class (".$driverClass.")");
        }
        // are there config settings set for this driver if not set it to blank
        if(!isset($this->supported_drivers[ucfirst($provider)]['config']))
        {
            $this->supported_drivers[ucfirst($provider)]['config'] = array();
        }

        $databaseDriver = $this->loadDatabaseDriver(ucfirst($driverName));
        return $driver = new $driverClass(
                $this->session,
                $this->cookie,
                $databaseDriver,
                $provider,
                $this->supported_drivers[ucfirst($provider)]['config'],
                $this->httpPath
                );
    }

    public function __call($method,$params)
    {      
        
        if(is_null($this->driver))
        {
            if(isset($params[0]) && isset($this->supported_drivers[ucfirst($params[0])]))
            {                
                $this->driver = $this->loadDriver($this->supported_drivers[ucfirst($params[0])]['Driver']);
            }else{
                $this->driver = $this->loadDriver(); 
            }
        }
        
        if(method_exists($this->driver,$method))
        {
            return call_user_func_array(array($this->driver,$method), $params);
        }
    	else
        {
            throw new \Exception("the requested function is not available for the requested driver");         
        }
    }

   protected function loadDatabaseDriver($authDriverName){

       $driverName = $this->config['database_driver'];
       $databaseDriverClass = 'TwswebInt\ICamelotAuth\Database\\'.ucfirst($driverName).'DatabaseDriver';
       return new $databaseDriverClass($authDriverName);
   }


}