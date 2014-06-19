<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Core\Messages;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EntityDescriptor;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\SAMLElementInterface;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class AuthnRequest extends RequestAbstractType implements SAMLElementInterface
{
    /**
     * elements
     */

    /**
     * Specifies the requested subject of the resulting assertion(s)
     *
     * @var string|null
     */
    protected $subjectc = null;

    /**
     * Specifies constraints on the name identifier to be used to represent the requested subject
     *
     * @var array|null
     */
    protected $nameIDPolicy = null;

    /**
     * Specifies the SAML conditions the requester expects to limit the validity and/or
     * use of the resulting assertions
     *
     * @var string|null
     */
    protected $conditions = null;

    /**
     * specifies the requirements, if any that the requester places on the authentication context
     *
     * @var array|null
     */
    protected $requestedAuthContext = null;

    /**
     * Specifies a set of identity providers trusted by the requester to authenticate the user
     *
     * @var string|null
     */
    protected $scoping = null;

    /**
     * attributes
     */


    /**
     * a value to determain if the idp must re-authenticate the user
     *
     * @var boolean
     */
    protected $forceAuthn = false;

    /**
     * value to detrmain if the idp or useragent can take visable controll
     *
     * @var boolean
     */
    protected $isPassive = false;



    /**
     * indicates the id of the assertion consumer service that should be used to send the respons message to
     *
     * @var int|null
     */
    protected $assertionConsumerServiceIndex = null;

    /**
     * indicates the url of the assertion consumer service where the response message should be sent
     *
     * @var string|null
     */
    protected $assertionConsumerServiceURL = null;

    /**
     * tells the idp what protocol binding should be used to send when returning the response message
     *
     * @var string|null
     */
    protected $protocolBinding = null;


    protected $bindingOptions = [
        Saml2Constants::Binding_HTTP_POST,
        Saml2Constants::Binding_HOK_SSO,
        Saml2Constants::Binding_HTTP_Artifact,
        Saml2Constants::Binding_HTTP_Redirect
    ];

    /**
     * indicates the id of the attribute consuming service to be used for the response message
     *
     * @var int|null
     */
    protected $attributeConsumingServiceIndex = null;

    /**
     * specifies the human readable name of the sp
     *
     * @var string|null
     */
    protected $providerName = null;

    /**
     * Specifies if the request should be signed before sending
     *
     * @var bool
     */
    protected $signRequest = false;


    public function __contruct($message = null,EntityDescriptor $spMetadata = null)
    {
        parent::__construct('AuthnRequest',$message);

        if(is_null($message))
        {
            return;
        }

        if($message instanceof EntityDescriptor)
        {
            $this->importMetadataSettings($message,$spMetadata);
        }
        else if($message instanceof \DOMElement)
        {
            $this->importXML($message);
        }
    }

    public function importMetadataSettings(EntityDescriptor $idpMetadata,EntityDescriptor $spMetadata)
    {
        $this->nameIDPolicy = array(
            'Format' => $spMetadata->getAttribute('NameIDFormat', Saml2Constants::NameID_Transient),
            'AllowCreate' => TRUE);

        $this->forceAuthn = $spMetadata->getAttribute('ForceAuthn', FALSE);
        $this->isPassive = $spMetadata->getAttribute('IsPassive', FALSE);


        $this->protocolBinding = $spMetadata->getValidatedValue('ProtocolBinding', $this->bindingOptions, Saml2Constants::Binding_HTTP_POST);

        if ($this->protocolBinding === Saml2Constants::Binding_HOK_SSO) {
            $destination = $idpMetadata->getDefaultEndpoint('SingleSignOnService', array(Saml2Constants::Binding_HOK_SSO));
        } else {
            $destination = $idpMetadata->getDefaultEndpoint('SingleSignOnService', array(Saml2Constants::Binding_HTTP_Redirect));
        }
        $this->destination = $destination['Location'];
        $this->issuer = $spMetadata->getEntityID();

    }
} 