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
        if(!array_key_exists($authnContext,$this->authnContextOptions))
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


}
