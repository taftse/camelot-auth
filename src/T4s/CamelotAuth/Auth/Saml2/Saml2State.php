<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 28/06/2014
 * Time: 16:47
 */

namespace T4s\CamelotAuth\Auth\Saml2;


use T4s\CamelotAuth\Auth\AbstractState;
use T4s\CamelotAuth\Auth\Saml2\Core\Messages\AbstractMessage;

class Saml2State extends AbstractState
{

    protected $message;

    public function __construct(AbstractMessage $message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
} 