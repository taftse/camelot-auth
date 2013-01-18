<?php namespace TwswebInt\CamelotAuth;

use TwswebInt\CamelotAuth\Drivers;
use TwswebInt\CamelotAuth\DatabaseDrivers;
use Illuminate\Session\Store;
use Config;

class Camelot{

    /**
     * The session store used by camelotauth
     *
     * @var Illuminate\Session\Store
     */
    protected $session;

    /**
     * A list of supported drivers 
     *
     * @var array
     */
    protected $supported_drivers = array();

    /**
     * Loaded Authentication Driver.
     *
     * @return void
     */
    protected $driver = null;

    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

        $this->supported_drivers = $this->app['config']['camelot-auth::camelot.provider_routing'];
        
    }

    public function loadDriver($driver = null)
    {
        $provider = null;
        // there is no driver specified lets try and detect the required driver
        if(is_null($driver))
        {
            // if detect_provider == true 
            if($this->app['config']['camelot-auth::camelot.detect_provider'])
            {
                $segments = explode("/", $this->app['request']->path());
                
                if(isset($segments[$this->app['config']['camelot-auth::camelot.route_location']-1]))
                {
                    $provider = $segments[$this->app['config']['camelot-auth::camelot.route_location']-1];
                
                    if(isset($this->supported_drivers[ucfirst($provider)]))
                    {
                       $driver = $this->supported_drivers[ucfirst($provider)]['Driver'];
                    }
                }
            }

            // if the driver is still null lets just load the default driver
           
            if(is_null($driver))
            {
                $driver = $this->app['config']['camelot-auth::camelot.default_driver'];
            }
        }
        
        // lets load the specified driver
        $driverFile = __DIR__.'/Drivers/'.ucfirst($driver).'CamelotDriver.php';
        if(!file_exists($driverFile))
        {
            throw new \Exception("Cannot Find the ".ucfirst($driver)." Driver");
        }
        include_once $driverFile;
        
        $driverClass ='TwswebInt\CamelotAuth\Drivers\\'.ucfirst($driver).'CamelotDriver';
        if(!class_exists($driverClass,false))
        {
            throw new \Exception("Cannot Find Driver class");
        }
        $databaseDriver = $this->loadDatabaseDriver(ucfirst($driver));
        $this->driver = new $driverClass($this->app,$databaseDriver,$provider);
    }

    public function __call($method,$params)
    {      
        if(is_null($this->driver))
        {
            if(isset($params[0]) && isset($this->supported_drivers[ucfirst($params[0])]))
            {                
                $this->loadDriver($this->supported_drivers[ucfirst($params[0])]['Driver']);
            }else{
                $this->loadDriver(); 
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

   protected function loadDatabaseDriver($authDriver){

       $driverName = $this->app['config']['camelot-auth::camelot.database_driver'];
       $databaseDriverClass = 'TwswebInt\CamelotAuth\DatabaseDrivers\\'.ucfirst($driverName).'DatabaseDriver';
       return new $databaseDriverClass($this->app,$authDriver);
   }


}