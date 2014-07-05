<?php
/**
 * Camelot Auth
  *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

namespace T4s\CamelotAuth\Auth\Saml2\Core\Elements;


use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\SAMLElementInterface;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

class AuthnStatement extends Statement implements SAMLElementInterface
{
    /**
     * attributes
     */

    protected $authnInstant;

    protected $sessionIndex = null;

    protected $sessionNotOnOrAfter = null;

    /**
     * elements
     */


    protected $subjectLocality = null;

    protected $authnContext;

    protected $authnContextOptions = [
        //Saml2Constants::AuthnContext_InternetProtocol,
        //Saml2Constants::AuthnContext_InternetProtocolPassword,
        //Saml2Constants::AuthnContext_Kerberos,
        //Saml2Constants::AuthnContext_MobileOneFactorUnregistered,
        //Saml2Constants::AuthnContext_MobileTwoFactorUnregistered,
        //Saml2Constants::AuthnContext_MobileOneFactorContract,
        //Saml2Constants::AuthnContext_MobileTwoFactorContract,
        Saml2Constants::AuthnContext_Password,
        //Saml2Constants::AuthnContext_PasswordProtectedTransport,
        //Saml2Constants::AuthnContext_PreviousSession,
        //Saml2Constants::AuthnContext_X509,
        //Saml2Constants::AuthnContext_PGP,
        //Saml2Constants::AuthnContext_SPKI,
        //Saml2Constants::AuthnContext_XMLDSig,
        //Saml2Constants::AuthnContext_Smartcard,
        //Saml2Constants::AuthnContext_SmartcardPKI,
        //Saml2Constants::AuthnContext_SoftwarePKI,
        //Saml2Constants::AuthnContext_Telephony,
        //Saml2Constants::AuthnContext_NomadTelephony,
        //Saml2Constants::AuthnContext_PersonalTelephony,
        //Saml2Constants::AuthnContext_AuthenticatedTelephony,
        //Saml2Constants::AuthnContext_SecureRemotePassword,
        //Saml2Constants::AuthnContext_TLSClient,
        //Saml2Constants::AuthnContext_TimeSyncToken,
        Saml2Constants::AuthnContext_Unspecified,
    ];

    public function __construct()
    {
        $this->authnInstant = time();
        $this->sessionIndex = bin2hex(openssl_random_pseudo_bytes(24));
    }

    public function setAuthnContext($authnContext)
    {
        if(!in_array($authnContext,$this->authnContextOptions,TRUE))
        {
            throw new \Exception("unsupported AuthnContext: ".$authnContext);
        }
        $this->authnContext = $authnContext;
    }

    public function getAuthnContext()
    {
        return $this->authnContext;
    }

    public function setSessionNotOnOrAfter($sessionNotOnOrAfter)
    {
        $this->sessionNotOnOrAfter = $sessionNotOnOrAfter;
    }

    public function toXML(\DOMElement $parentElement)
    {
        $authnStatement = $parentElement->ownerDocument->createElementNS(Saml2Constants::Namespace_SAML,'saml:AuthnStatement');
        $parentElement->appendChild($authnStatement);

        $authnStatement->setAttribute('AuthnInstant',date('Y-m-d\TH:i:s\Z',$this->authnInstant));

        if(!is_null($this->sessionIndex))
        {
            $authnStatement->setAttribute('SessionIndex',$this->sessionIndex);
        }

        if(!is_null($this->sessionNotOnOrAfter))
        {
            $authnStatement->setAttribute('SessionNotOnOrAfter',date('Y-m-d\TH:i:s\Z',$this->sessionNotOnOrAfter));
        }

        $this->authnContext->toXML($authnStatement);

        if(!is_null($this->subjectLocality))
        {
            foreach($this->subjectLocality as $subjectLocality)
            {
                $subjectLocality->toXML($authnStatement);
            }
        }

        return $authnStatement;
    }

    public function importXML(\DOMElement $node)
    {
        throw new \Exception('unfinished function AuthnStatement->importXML()');
    }


}
