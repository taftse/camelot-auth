<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Core\Messages;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\SAMLElementInterface;

abstract class RequestAbstractType implements SAMLElementInterface
{
    /**
     * Attributes
     */
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





    protected $signature = null;

    protected $extensions = null;


    protected $xmlMessage= null;

    protected $messageType;

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
            return $this->importXML($message);
        }
    }

    public function toXML(\DOMElement $parentElement)
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
} 