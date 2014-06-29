<?php
/**
 * Created by PhpStorm.
 * User: LocalAdmin
 * Date: 20/06/2014
 * Time: 15:09
 */

namespace T4s\CamelotAuth\Auth\Saml2\Core\Messages;


use T4s\CamelotAuth\Auth\Saml2\Core\Elements\ArtifactResolve;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\ArtifactResponse;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\AttributeQuery;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\LogoutRequest;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\LogoutResponse;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

abstract class AbstractMessage
{
    /**
     * The Identifier for the request
     *
     * @var string
     */
    protected $id;

    /**
     * The Version of the request
     *
     * @var int
     */
    protected $version = '2.0';

    /**
     * The time the request is issued (eg now)
     *
     * @var dateTime
     */
    protected $issueInstant;

    /**
     * the uri from which this request has been sent
     * (optional)
     *
     * @var string|null
     */
    protected $destination = null;

    /**
     * indicates if consent was obtained from the user
     * (optional)
     *
     * @var string
     */
    protected $consent = Saml2Constants::Consent_Unspecified;

    /**
     * elements
     */

    /**
     * Identifies the entity that generated the message
     *
     * @var string
     */
    protected $issuer = null;


    protected $xmlMessage= null;

    protected $messageType;

    protected $relayState = null;


    public function __construct($messageType,$message = null)
    {
        $this->xmlMessage = new \DOMDocument();
        $this->messageType = $messageType;
        $this->id = uniqid();
        $this->issueInstant = time();



        if(is_null($message))
        {
            return;
        }

        if($message instanceof \DOMElement)
        {
           $this->importXML($message);
        }
    }

    public function getRelayState()
    {
        return $this->relayState;
    }

    public function setRelayState($relayState)
    {
        $this->relayState = $relayState;
    }

    public function toXML()
    {

        $root = $this->xmlMessage->createElementNS(Saml2Constants::Namespace_SAMLProtocol,'samlp:'.$this->messageType);
        $this->xmlMessage->appendChild($root);

        $root->setAttribute('ID',$this->id);
        $root->setAttribute('Version',$this->version);
        $root->setAttribute('IssueInstant',date('Y-m-d\TH:i:s\Z',$this->issueInstant));

        if(!is_null($this->destination))
        {
            $root->setAttribute('Destination',$this->destination);
        }

        if(!is_null($this->issuer))
        {
            $n = $root->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML,'saml:Issuer');
            $n->appendChild($root->ownerDocument->createTextNode($this->issuer));
            $root->appendChild($n);
        }

        return $root;
    }

    public function importXML(\DOMElement $node)
    {
        if(!$node->hasAttribute('ID'))
        {
            throw new \Exception("The SAML message is missing the ID attribute");
        }
        $this->id = $node->getAttribute('ID');

        if($node->getAttribute('Version') != '2.0')
        {
            throw new \Exception("Unsupported Version: ".$node->getAttribute('Version'));
        }

        $this->issueInstant = \DateTime::createFromFormat('Y-m-d\TH:i:s\Z',$node->getAttribute('IssueInstant'))->getTimestamp();


        if(!$node->hasAttribute('Destination'))
        {
            $this->destination = $node->getAttribute('Destination');
        }

        $this->issuer = $node->ownerDocument->getElementsByTagNameNS(Saml2Constants::Namespace_SAML, 'Issuer')->item(0)->nodeValue;

        //$this->validateSignature($node);

    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function getXMLMessage()
    {
        return $this->xmlMessage;
    }

    public function getIssuer()
    {
        return $this->issuer;
    }

    public function getID()
    {
        return $this->id;
    }

    public static function getMessageFromXML(\DOMElement $message)
    {
        if($message->namespaceURI  != Saml2Constants::Namespace_SAMLProtocol)
        {
            throw new \Exception("Unknown saml request namespace ".$message->namespaceURI);
        }

        switch($message->localName)
        {
            case 'AttributeQuery':
                return new AttributeQuery($message);
                break;
            case 'AuthnRequest':
                return new AuthnRequest($message);
                break;
            case 'LogoutResponse':
                return new LogoutResponse($message);
                break;
            case 'LogoutRequest':
                return new LogoutRequest($message);
                break;
            case 'Response':
                return new Response($message);
                break;
            case 'ArtifactResponse':
                return new ArtifactResponse($message);
                break;
            case 'ArtifactResolve':
                return new ArtifactResolve($message);
                break;

            default:
                throw new \Exception("Unknown message type ".$message->localName);
                break;

        }
    }
}