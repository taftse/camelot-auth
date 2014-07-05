<?php

/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */

return array(
    "locations" =>array(
        "https://edugate.heanet.ie/edugate-federation-metadata-signed.xml",
        "https://app.onelogin.com/saml/metadata/343584",
        "",
    ),

    "metadata" => [
        'https://login.tools4schools.ie' => [
            'NameIDFormat'=>'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
            'Certificate' => [
                'use'=>'signing',
                'key'=>'MIIBrTCCAaGgAwIBAgIBATADBgEAMGcxCzAJBgNVBAYTAlVTMRMwEQYDVQQIDApD
YWxpZm9ybmlhMRUwEwYDVQQHDAxTYW50YSBNb25pY2ExETAPBgNVBAoMCE9uZUxv
Z2luMRkwFwYDVQQDDBBhcHAub25lbG9naW4uY29tMB4XDTExMDYyNzE2MDIzNFoX
DTE2MDYyNjE2MDIzNFowZzELMAkGA1UEBhMCVVMxEzARBgNVBAgMCkNhbGlmb3Ju
aWExFTATBgNVBAcMDFNhbnRhIE1vbmljYTERMA8GA1UECgwIT25lTG9naW4xGTAX
BgNVBAMMEGFwcC5vbmVsb2dpbi5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJ
AoGBAN0f5UDHxn/KGyEdhsr55cnVthzJvVdFBvyMU0PvjIjrFYI7uzB7q2vRAWUK
YLLpGr7vWTT7gVaCBsiQsbteo9noBXaoAooeJYf4S/VuD3LH4Sjn0o9V+/Un/4JZ
dkrhHtfUW/Qc2eBcuttZN2+Z9Uahx6soxYCsgTFrHSq12u6RAgMBAAEwAwYBAAMB
AA=='       ],
            'IDPSSODescriptor' =>[
                'protocolSupportEnumeration' => \T4s\CamelotAuth\Auth\Saml2\Saml2Constants::Namespace_SAMLProtocol,
                'SingleSignOnService' => [
                    0 =>   [
                        'Binding'   =>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                        'Location'  =>'http://login.tools4schools.ie/saml2/SSO'
                    ],
                    1 =>   [
                        'Binding'   =>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
                        'Location'  =>'http://login.tools4schools.ie/saml2/SSO'
                    ],
                    2 =>   [
                        'Binding'   =>'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
                        'Location'  =>'http://login.tools4schools.ie/saml2/SSO'
                    ],

                ],
            ]
        ],
        'https://dashboard.pay4school.local' => [
            'NameIDFormat'=>'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
            'Certificate' => [
                'use'=>'signing',
                'key'=>'MIIBrTCCAaGgAwIBAgIBATADBgEAMGcxCzAJBgNVBAYTAlVTMRMwEQYDVQQIDApD
YWxpZm9ybmlhMRUwEwYDVQQHDAxTYW50YSBNb25pY2ExETAPBgNVBAoMCE9uZUxv
Z2luMRkwFwYDVQQDDBBhcHAub25lbG9naW4uY29tMB4XDTExMDYyNzE2MDIzNFoX
DTE2MDYyNjE2MDIzNFowZzELMAkGA1UEBhMCVVMxEzARBgNVBAgMCkNhbGlmb3Ju
aWExFTATBgNVBAcMDFNhbnRhIE1vbmljYTERMA8GA1UECgwIT25lTG9naW4xGTAX
BgNVBAMMEGFwcC5vbmVsb2dpbi5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJ
AoGBAN0f5UDHxn/KGyEdhsr55cnVthzJvVdFBvyMU0PvjIjrFYI7uzB7q2vRAWUK
YLLpGr7vWTT7gVaCBsiQsbteo9noBXaoAooeJYf4S/VuD3LH4Sjn0o9V+/Un/4JZ
dkrhHtfUW/Qc2eBcuttZN2+Z9Uahx6soxYCsgTFrHSq12u6RAgMBAAEwAwYBAAMB
AA=='       ],
            'SPSSODescriptor' =>[
                'protocolSupportEnumeration' => \T4s\CamelotAuth\Auth\Saml2\Saml2Constants::Namespace_SAMLProtocol,
                'AuthnRequestsSigned' =>false,
                'SingleLogoutService' => [
                    0 => [
                        'Binding'   => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                        'Location'  => 'https://app.onelogin.com/trust/saml2/http-post/sso/343584'
                    ],
                ],
                'AssertionConsumerService' => [
                    0 => [
                        'isDefault' => true,
                        'index'     => 0,
                        'Binding'   => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
                        'Location'  => 'https://dashboard.pay4schools.local/login/acs',
                    ],
                    1 => [
                        'isDefault' => false,
                        'index'     => 1,
                        'Binding'   => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
                        'Location'  => 'https://dashboard.pay4schools.local/login/acs',
                    ],
                ],
                'AttributeConsumingService' => [
                    'ServiceName' => ['en' =>'Pay4School school payment solution'],
                    'RequestedAttribute' => [
                        0 => [
                            'NameFormat'     => 'mail',
                            'Name'           => 'urn:oid:0.9.2342.19200300.100.1.3',
                            'FriendlyName'   => 'email',
                            'isRequired'     => '',
                        ],
                    ],
                ],
            ],
        ],
        'https://app.onelogin.com/saml/metadata/343584' => [
            'NameIDFormat'=>'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
            'Certificate' => [
                'use' => 'signing',
                'key' => 'MIIBrTCCAaGgAwIBAgIBATADBgEAMGcxCzAJBgNVBAYTAlVTMRMwEQYDVQQIDApD
YWxpZm9ybmlhMRUwEwYDVQQHDAxTYW50YSBNb25pY2ExETAPBgNVBAoMCE9uZUxv
Z2luMRkwFwYDVQQDDBBhcHAub25lbG9naW4uY29tMB4XDTExMDYyNzE2MDIzNFoX
DTE2MDYyNjE2MDIzNFowZzELMAkGA1UEBhMCVVMxEzARBgNVBAgMCkNhbGlmb3Ju
aWExFTATBgNVBAcMDFNhbnRhIE1vbmljYTERMA8GA1UECgwIT25lTG9naW4xGTAX
BgNVBAMMEGFwcC5vbmVsb2dpbi5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJ
AoGBAN0f5UDHxn/KGyEdhsr55cnVthzJvVdFBvyMU0PvjIjrFYI7uzB7q2vRAWUK
YLLpGr7vWTT7gVaCBsiQsbteo9noBXaoAooeJYf4S/VuD3LH4Sjn0o9V+/Un/4JZ
dkrhHtfUW/Qc2eBcuttZN2+Z9Uahx6soxYCsgTFrHSq12u6RAgMBAAEwAwYBAAMB
AA=='       ],
            'IDPSSODescriptor' =>[
                'protocolSupportEnumeration' => \T4s\CamelotAuth\Auth\Saml2\Saml2Constants::Namespace_SAMLProtocol,
                'SingleSignOnService' => [
                    0 => [
                        'Binding'   => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                        'Location'  => 'https://app.onelogin.com/trust/saml2/http-post/sso/343584'
                    ],
                    1 => [
                        'Binding'   => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
                        'Location'  => 'https://app.onelogin.com/trust/saml2/http-post/sso/343584'
                    ],
                    2 => [
                        'Binding'   => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
                        'Location'  => 'https://app.onelogin.com/trust/saml2/soap/sso/343584'
                    ],
                ],
            ],
        ],
        'https://login.gfhgtools4schools.ie' => [
            'NameIDFormat'=>'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
            'Certificate' => [
                'use' => 'signing',
                'key' => 'MIIBrTCCAaGgAwIBAgIBATADBgEAMGcxCzAJBgNVBAYTAlVTMRMwEQYDVQQIDApD YWxpZm9ybmlhMRUwEwYDVQQHDAxTYW50YSBNb25pY2ExETAPBgNVBAoMCE9uZUxv Z2luMRkwFwYDVQQDDBBhcHAub25lbG9naW4uY29tMB4XDTExMDYyNzE2MDIzNFoX DTE2MDYyNjE2MDIzNFowZzELMAkGA1UEBhMCVVMxEzARBgNVBAgMCkNhbGlmb3Ju aWExFTATBgNVBAcMDFNhbnRhIE1vbmljYTERMA8GA1UECgwIT25lTG9naW4xGTAX BgNVBAMMEGFwcC5vbmVsb2dpbi5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJ AoGBAN0f5UDHxn/KGyEdhsr55cnVthzJvVdFBvyMU0PvjIjrFYI7uzB7q2vRAWUK YLLpGr7vWTT7gVaCBsiQsbteo9noBXaoAooeJYf4S/VuD3LH4Sjn0o9V+/Un/4JZ dkrhHtfUW/Qc2eBcuttZN2+Z9Uahx6soxYCsgTFrHSq12u6RAgMBAAEwAwYBAAMB AA=='       ],
            'IDPSSODescriptor' =>[
                'protocolSupportEnumeration' => \T4s\CamelotAuth\Auth\Saml2\Saml2Constants::Namespace_SAMLProtocol,
                'SingleSignOnService' => [
                    0 => [
                        'Binding'   =>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                        'Location'  =>'https://app.onelogin.com/trust/saml2/http-post/sso/297476'
                    ],
                    1 => [
                        'Binding'   =>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
                        'Location'  =>'https://app.onelogin.com/trust/saml2/http-post/sso/297476'
                    ],
                    2 => [
                        'Binding'   =>'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
                        'Location'  =>'https://app.onelogin.com/trust/saml2/soap/sso/297476'
                    ],
                ],
            ],
        ],
    ],
);