<?php namespace T4s\CamelotAuth\Auth\Saml2;

class Saml2Constants{
	/**
	 * Consent Types
	 */
	
	const Consent_Unspecified 		= 'urn:oasis:names:tc:SAML:2.0:consent:unspecified';

	const Consent_Obtained 			= 'urn:oasis:names:tc:SAML:2.0:consent:obtained';

	const Consent_Prior 			= 'urn:oasis:names:tc:SAML:2.0:consent:prior';

	const Consent_Implicit 			= 'urn:oasis:names:tc:SAML:2.0:consent:implicit';

	const Consent_Explicit 			= 'urn:oasis:names:tc:SAML:2.0:consent:explicit';

	const Consent_Unavailable 		= 'urn:oasis:names:tc:SAML:2.0:consent:unavialable';

	const Consent_Inapplicable 		= 'urn:oasis:names:tc:SAML:2.0:consent:inapplicable';

	/**
	 * Namespaces 
	 */
	
	const Namespace_SAMLProtocol	= 'urn:oasis:names:tc:SAML:2.0:protocol';

	const Namespace_SAML 			= 'urn:oasis:names:tc:SAML:2.0:assertion';

	/**
	 * Name Formats
	 */

	const NameFormat_Unspecified 	= 'urn:oasis:names:tc:SAML:2.0:attrname-format:unspecified';
	/**
	 * Name ID Formats
	 */

	const NameID_Unspecified 		= 'urn:oasis:names:tc:SAML:2.0:nameid-format:unspecified';

	const NameID_Persistent			= 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent';

	const NameID_Transient			= 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient';
	
	const NameID_Encrypted			= 'urn:oasis:names:tc:SAML:2.0:nameid-format:encrypted';

	/**
	 * Binding Options
	 */

	const Binding_HTTP_POST			= 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST';

	const Binding_HTTP_Artifact		= 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact';

	const Binding_HTTP_Redirect		= 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect';

	const Binding_SOAP				= 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP';

	const Binding_HOK_SSO			= 'urn:oasis:names:tc:SAML:2.0:profiles:holder-of-key:SSO:browser';
}