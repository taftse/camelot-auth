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
            'NameIDFormat'=>'urn:oasis:names:tc:SAML:1.1:nameid-format:transient',
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
                'SingleSignOnService' => [
                    [
                        0 =>   [
                            'Binding'   =>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                            'Location'  =>'http://login.tools4schools.ie/saml2/'
                        ],
                        1 =>   [
                            'Binding'   =>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
                            'Location'  =>'http://login.tools4schools.ie/saml2/'
                        ],
                        2 =>   [
                            'Binding'   =>'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
                            'Location'  =>'http://login.tools4schools.ie/saml2/'
                        ],
                    ],
                ],
            ]
        ],
        'https://dashboard.pay4school.local' => [
            'NameIDFormat'=>'urn:oasis:names:tc:SAML:1.1:nameid-format:transient',
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
            'SPSSODescriptor' =>[],
        ],
    ],
);