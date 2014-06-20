<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 20/06/2014
 * Time: 12:52
 */

namespace T4s\CamelotAuth\Auth\Saml2\Bindings;


use T4s\CamelotAuth\Auth\Saml2\Core\Messages\AbstractMessage;

abstract class Binding
{
    protected $destination;

    public function getDestination()
    {
        return $this->destination;
    }

    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    public static function getBinding()
    {
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                if(array_key_exists('SAMLRequest',$_GET)|| array_key_exists('SAMLResponse',$_GET))
                {
                    return new HTTPRedirectBinding();
                }
                else if(array_key_exists('SAMLart',$_GET))
                {
                    return new HTTPArtifactBinding();
                }
                break;
            case 'POST':
                $contentType = null;
                if(isset($_SERVER['CONTENT_TYPE']))
                {
                    $contentType = explode(';',$_SERVER['CONTENT_TYPE']);
                    $contentType = $contentType[0];
                }

                if(array_key_exists('SAMLRequest',$_POST)|| array_key_exists('SAMLResponse',$_POST))
                {
                    return new HTTPPostBinding();
                }
                else if(array_key_exists('SAMLart',$_POST))
                {
                    return new HTTPArtifactBinding();
                }
                else if($contentType =='text/xml')
                {
                    return new SOAPBinding();
                }
                break;
        }
    }

    abstract public function send(AbstractMessage $message);

    abstract public function receive();
} 