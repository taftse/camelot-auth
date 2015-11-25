<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4S\CamelotAuth\Session;

use Illuminate\Session\Store as SessionStore;

class IlluminateSession implements SessionInterface
{
    protected $key = "camelot-auth";

    protected $store;

    public function __construct(SessionStore $store,$key = "camelot-auth-session")
    {
        $this->store = $store;
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function put($value,$key=null)
    {
        if(is_null($key)){
            $key = $this->key;
        }

        $this->store->put($key,$value);
    }

    public function get($key = null,$default = null)
    {
        if(is_null($key))
        {
            $key = $this->key;
        }
        return $this->store->get($key,$default);
    }

    public function forget($key = null)
    {
        if(is_null($key))
        {
            $key = $this->key;
        }
        $this->store->forget($key);
    }

    public function all()
    {
        return $this->store->all();
    }
} 