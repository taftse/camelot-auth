<?php namespace TwswebInt\CamelotAuth;

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

    public function __constructor($app)
    {
        $this->app = $app;
        echo 'loading';
        Log::info('This is some useful information.');
        $this->supported_drivers = Config::get('camelotauth::camelotauth.provider_routing');
    }

   /* public function driver($driver = null)
    {
    	if(is_null($driver)){
    		$driver = Config::get('camelotauth.default_driver');
    	}

    	if(!isset($this->drivers[$driver]))
    	{
    		$this->drivers[$driver] = $this->loadDriver($driver);
    	}
    	return $this->drivers[$driver];
    }*/

  /*  public functiondriver($driver = null)
    {
        // if driver is not null then we want to set a new loaded driver
        if(!is_null($driver) && (is_null($this->driver)) )
        {
            $this->loadDriver($driver);
        }

        if()
    }*/

    public function loadDriver($driver = null)
    {
        // there is no driver specified lets try and detect the required driver
        if(is_null($driver))
        {
            // if detect_provider == true 
            if(Config::get('camelotauth::camelotauth.detect_provider'))
            {

            }

            // if the driver is still null lets just load the default driver
            if(is_null($driver))
            {
                $driver = Config::get('camelotauth::camelotauth.default_driver');
            }
        }
        echo $driver;
        // lets load the specified driver


        //$this->driver = new $driver_class
    }

    public function __call($method,$params)
    {      
        if(is_null($this->driver))
        {
           var_dump($this->app['config']['camelot.provider_routing']);
            if(isset($params[0]) && isset($this->supported_drivers[ucfirst($params[0])]))
            {
                echo "string";
                $this->loadDriver($this->supported_drivers[ucfirst($params[0])]['Driver']);
            }else{
                //echo "null";
                $this->loadDriver(); 
            }
        }

        if(method_exists($this->driver,$method))
        {
            return call_user_func_array(array($this->driver,$method), $params);
        }
    	else
        {
            throw new \Exception("the requested function is not available for the requested driver", 1);         
        }
    }
}