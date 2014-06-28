<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth;

abstract class AbstractState {

    protected $returnToUrl;

    protected $returnCallbackClass;

    protected $returnCallbackMethod;

    public function setCallaback($class,$method)
    {
        $this->returnCallbackClass = $class;
        $this->returnCallbackMethod = $method;
    }

    public function getCallaback()
    {
        return ['class' =>$this->returnCallbackClass,'method'=>$this->returnCallbackMethod];
    }

} 