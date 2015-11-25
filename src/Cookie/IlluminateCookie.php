<?php namespace T4S\CamelotAuth\Cookie;

use Illuminate\Http\Request;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieJar;

class IlluminateCookie implements CookieInterface
{
    protected $key = "camelot-auth";
    protected $cookieJar;
    protected $cookie;
    protected $request;

    public function __construct(Request $request,CookieJar $cookieJar,$key = "camelot-auth")
    {
        $this->cookieJar = $cookieJar;
        $this->key = $key;
        $this->request = $request;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function put($value,$minutes,$key= null)
    {

    }
    public function forever($value)
    {
        return $this->cookie = $this->cookieJar->forever($this->getKey(),$value);
    }
    public function get($key= null)
    {

    }
    public function forget($key= null)
    {

    }
    public function getCookie()
    {

    }
}