<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */


namespace T4s\CamelotAuth\Auth\Saml2;


class Saml2Constants
{
    /**
     * Consent Types
     */

    const Consent_Unspecified 				        = 'urn:oasis:names:tc:SAML:2.0:consent:unspecified';

    const Consent_Obtained 					        = 'urn:oasis:names:tc:SAML:2.0:consent:obtained';

    const Consent_Prior 					        = 'urn:oasis:names:tc:SAML:2.0:consent:prior';

    const Consent_Implicit 					        = 'urn:oasis:names:tc:SAML:2.0:consent:implicit';

    const Consent_Explicit 					        = 'urn:oasis:names:tc:SAML:2.0:consent:explicit';

    const Consent_Unavailable 				        = 'urn:oasis:names:tc:SAML:2.0:consent:unavialable';

    const Consent_Inapplicable 				        = 'urn:oasis:names:tc:SAML:2.0:consent:inapplicable';

    /**
     * Namespaces
     */

    const Namespace_SAMLProtocol		    	    = 'urn:oasis:names:tc:SAML:2.0:protocol';

    const Namespace_SAML 				    	    = 'urn:oasis:names:tc:SAML:2.0:assertion';

    const Namespace_Metadata                        = 'urn:oasis:names:tc:SAML:2.0:metadata';

    /**
     * Name Formats
     */

    const NameFormat_Unspecified 		    	    = 'urn:oasis:names:tc:SAML:2.0:attrname-format:unspecified';
    /**
     * Name ID Formats
     */

    const NameID_Unspecified 		    		    = 'urn:oasis:names:tc:SAML:2.0:nameid-format:unspecified';

    const NameID_Persistent			    		    = 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent';

    const NameID_Transient			    		    = 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient';

    const NameID_Encrypted			    		    = 'urn:oasis:names:tc:SAML:2.0:nameid-format:encrypted';

    /**
     * Binding Options
     */

    const Binding_HTTP_POST				    	    = 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST';

    const Binding_HTTP_Artifact			    	    = 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact';

    const Binding_HTTP_Redirect			    	    = 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect';

    const Binding_SOAP				    		    = 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP';

    const Binding_HOK_SSO				    	    = 'urn:oasis:names:tc:SAML:2.0:profiles:holder-of-key:SSO:browser';

    const Binding_Encoding_DEFLATE		    	    = 'urn:oasis:names:tc:SAML:2.0:bindings:URL-Encoding:DEFLATE';

    /**
     * StatusCodes
     */

    const Status_Success				    	    = 'urn:oasis:names:tc:SAML:2.0:status:Success';

    const Status_Requester				    	    = 'urn:oasis:names:tc:SAML:2.0:status:Requester';

    const Status_Responder				    	    = 'urn:oasis:names:tc:SAML:2.0:status:Responder';

    const Status_VersionMismatch		    	    = 'urn:oasis:names:tc:SAML:2.0:status:VersionMismatch';

    const Status_AuthnFailed			    	    = 'urn:oasis:names:tc:SAML:2.0:status:AuthnFailed';

    const Status_InvalidAttrNameOrValue		        = 'urn:oasis:names:tc:SAML:2.0:status:InvalidAttrNameOrValue';

    const Status_InvalidNameIDPolicy	    	    = 'urn:oasis:names:tc:SAML:2.0:status:InvalidNameIDPolicy';

    const Status_NoAuthnContext			    	    = 'urn:oasis:names:tc:SAML:2.0:status:NoAuthnContext';

    const Status_NoAvailableIDP			    	    = 'urn:oasis:names:tc:SAML:2.0:status:NoAvailableIDP';

    const Status_NoPassive				    	    = 'urn:oasis:names:tc:SAML:2.0:status:NoPassive';

    const Status_NoSupportedIDP				        = 'urn:oasis:names:tc:SAML:2.0:status:NoSupportedIDP';

    const Status_PartialLogout				        = 'urn:oasis:names:tc:SAML:2.0:status:PartialLogout';

    const Status_ProxyCountExceeded			        = 'urn:oasis:names:tc:SAML:2.0:status:ProxyCountExceeded';

    const Status_RequestDenied				        = 'urn:oasis:names:tc:SAML:2.0:status:RequestDenied';

    const Status_RequestUnsupported			        = 'urn:oasis:names:tc:SAML:2.0:status:RequestUnsupported';

    const Status_RequestVersionDeprecated	        = 'urn:oasis:names:tc:SAML:2.0:status:RequestVersionDeprecated';

    const Status_RequestVersionTooHigh		        = 'urn:oasis:names:tc:SAML:2.0:status:RequestVersionTooHigh';

    const Status_RequestVersionTooLow		        = 'urn:oasis:names:tc:SAML:2.0:status:RequestVersionTooLow';

    const Status_ResourceNotRecognized		        = 'urn:oasis:names:tc:SAML:2.0:status:ResourceNotRecognized';

    const Status_TooManyResponses			        = 'urn:oasis:names:tc:SAML:2.0:status:TooManyResponses';

    const Status_UnknownAttrProfile			        = 'urn:oasis:names:tc:SAML:2.0:status:UnknownAttrProfile';

    const Status_UnknownPrincipal			        = 'urn:oasis:names:tc:SAML:2.0:status:UnknownPrincipal';

    const Status_UnsupportedBinding			        = 'urn:oasis:names:tc:SAML:2.0:status:UnsupportedBinding';




    const AuthnContext_Unspecified                  = 'urn:oasis:names:tc:SAML:2.0:ac:classes:unspecified';

    const AuthnContext_InternetProtocol             = 'urn:oasis:names:tc:SAML:2.0:ac:classes:InternetProtocol';

    const AuthnContext_InternetProtocolPassword     = 'urn:oasis:names:tc:SAML:2.0:ac:classes:InternetProtocolPassword';

    const AuthnContext_Kerberos                     ='urn:oasis:names:tc:SAML:2.0:ac:classes:Kerberos';

    const AuthnContext_MobileOneFactorUnregistered  = 'urn:oasis:names:tc:SAML:2.0:ac:classes:MobileOneFactorUnregistered';

    const AuthnContext_MobileTwoFactorUnregistered  = 'urn:oasis:names:tc:SAML:2.0:ac:classes:MobileTwoFactorUnregistered';

    const AuthnContext_MobileOneFactorContract      = 'urn:oasis:names:tc:SAML:2.0:ac:classes:MobileOneFactorContract';

    const AuthnContext_MobileTwoFactorContract      = 'urn:oasis:names:tc:SAML:2.0:ac:classes:MobileTwoFactorContract';

    const AuthnContext_Password                     = 'urn:oasis:names:tc:SAML:2.0:ac:classes:Password';

    const AuthnContext_PasswordProtectedTransport   = 'urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport';

    const AuthnContext_PreviousSession              = 'urn:oasis:names:tc:SAML:2.0:ac:classes:PreviousSession';

    const AuthnContext_X509                         = 'urn:oasis:names:tc:SAML:2.0:ac:classes:X509';

    const AuthnContext_PGP                          = 'urn:oasis:names:tc:SAML:2.0:ac:classes:PGP';

    const AuthnContext_SPKI                         = 'urn:oasis:names:tc:SAML:2.0:ac:classes:SPKI';

    const AuthnContext_XMLDSig                      = 'urn:oasis:names:tc:SAML:2.0:ac:classes:XMLDSig';

    const AuthnContext_Smartcard                    = 'urn:oasis:names:tc:SAML:2.0:ac:classes:Smartcard';

    const AuthnContext_SmartcardPKI                 = 'urn:oasis:names:tc:SAML:2.0:ac:classes:SmartcardPKI';

    const AuthnContext_SoftwarePKI                  = 'urn:oasis:names:tc:SAML:2.0:ac:classes:SoftwarePKI';

    const AuthnContext_Telephony                    = 'urn:oasis:names:tc:SAML:2.0:ac:classes:Telephony';

    const AuthnContext_NomadTelephony               = 'urn:oasis:names:tc:SAML:2.0:ac:classes:NomadTelephony';

    const AuthnContext_PersonalTelephony            = 'urn:oasis:names:tc:SAML:2.0:ac:classes:PersonalTelephony';

    const AuthnContext_AuthenticatedTelephony       = 'urn:oasis:names:tc:SAML:2.0:ac:classes:AuthenticatedTelephony';

    const AuthnContext_SecureRemotePassword         = 'urn:oasis:names:tc:SAML:2.0:ac:classes:SecureRemotePassword';

    const AuthnContext_TLSClient                    = 'urn:oasis:names:tc:SAML:2.0:ac:classes:TLSClient';

    const AuthnContext_TimeSyncToken                = 'urn:oasis:names:tc:SAML:2.0:ac:classes:TimeSyncToken';



    const SubjectConfirmation_Bearer                = 'urn:oasis:names:tc:SAML:2.0:cm:bearer';

    const SubjectConfirmation_HolderOfKey           = 'urn:oasis:names:tc:SAML:2.0:cm:holder-of-key';

    const SubjectConfirmation_SenderVouches         = 'urn:oasis:names:tc:SAML:2.0:cm:sender-vouches';
}