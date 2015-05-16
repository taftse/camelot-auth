<?php namespace T4s\CamelotAuth\Hasher;

class BcryptHasher implements HasherInterface
{
    /**
     * Default crypt cost factor.
     *
     * @var int
     */
    protected $cost = 8;

    public function __construct()
    {
        if(version_compare(PHP_VERSION, '5.3.7')<0)
        {
            throw new \RuntimeException("Bcrypt hahsing Requires PHP version 5.3.7 or greater");

        }
    }
    public function hash($string, array $options = array())
    {
        if(isset($options['cost']))
        {
            $this->cost = $options['cost'];
        }
        return password_hash($string, PASSWORD_BCRYPT,array('cost'=>$this->cost));
    }


    public function checkHash($string,$hashedString)
    {
        return password_verify($string,$hashedString);
    }
}