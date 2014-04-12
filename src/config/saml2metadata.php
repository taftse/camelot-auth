<?php

return array(

	'my_metadata' => array(),
	/*
    |--------------------------------------------------------------------------
    | Metadata
    |--------------------------------------------------------------------------
    |
    | This contains the metadata and will be used when the metadata_store 
    | is set to config 
    |
    |
    */
    'metadata' => array('https://app.onelogin.com/saml/metadata/343584'=> 
			    				array(

			    					'NameIDFormat'=>'urn:oasis:names:tc:SAML:1.1:nameid-format:transient',
			    					'Organization'=> array('OrganizationName'=>'OneLogin'),
			    					'IDPSSODescriptor' => 
			    					array(
			    						'KeyDescriptor' => array(array('use'=>'signing','key'=>'MIIBrTCCAaGgAwIBAgIBATADBgEAMGcxCzAJBgNVBAYTAlVTMRMwEQYDVQQIDApD
YWxpZm9ybmlhMRUwEwYDVQQHDAxTYW50YSBNb25pY2ExETAPBgNVBAoMCE9uZUxv
Z2luMRkwFwYDVQQDDBBhcHAub25lbG9naW4uY29tMB4XDTExMDYyNzE2MDIzNFoX
DTE2MDYyNjE2MDIzNFowZzELMAkGA1UEBhMCVVMxEzARBgNVBAgMCkNhbGlmb3Ju
aWExFTATBgNVBAcMDFNhbnRhIE1vbmljYTERMA8GA1UECgwIT25lTG9naW4xGTAX
BgNVBAMMEGFwcC5vbmVsb2dpbi5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJ
AoGBAN0f5UDHxn/KGyEdhsr55cnVthzJvVdFBvyMU0PvjIjrFYI7uzB7q2vRAWUK
YLLpGr7vWTT7gVaCBsiQsbteo9noBXaoAooeJYf4S/VuD3LH4Sjn0o9V+/Un/4JZ
dkrhHtfUW/Qc2eBcuttZN2+Z9Uahx6soxYCsgTFrHSq12u6RAgMBAAEwAwYBAAMB
AA==')),
			    						'SingleSignOnService'=>
			    						array(
				    						array(
				    							'Binding'=>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
				    							'Location'=>'https://app.onelogin.com/trust/saml2/http-post/sso/343584'
				    							),
				    						array(
				    							'Binding'=>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
				    							'Location'=>'https://app.onelogin.com/trust/saml2/http-post/sso/343584'
				    							),
				    						array(
				    							'Binding'=>'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
				    							'Location'=>'https://app.onelogin.com/trust/saml2/soap/sso/343584'
				    							),
				    						),
			    						  
			    						),
			    					),
						'https://tools4schools-dev-ed.my.salesforce.com'=>
							array(
								'NameIDFormat'=>'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
								'Organization'=> array('OrganizationName'=>'salesforce'),
								'IDPSSODescriptor' => 
			    					array(
										'KeyDescriptor' => array(array('use'=>'signing','key'=>'MIIErDCCA5SgAwIBAgIOAUKKRkd7AAAAACsv4TkwDQYJKoZIhvcNAQEFBQAwgZAxKDAmBgNVBAMMH1NlbGZTaWduZWRDZXJ0XzI0Tm92MjAxM18xMzIyMDkxGDAWBgNVBAsMDzAwRGIwMDAwMDAwYzZTcjEXMBUGA1UECgwOU2FsZXNmb3JjZS5jb20xFjAUBgNVBAcMDVNhbiBGcmFuY2lzY28xCzAJBgNVBAgMAkNBMQwwCgYDVQQGEwNVU0EwHhcNMTMxMTI0MTMyMjEwWhcNMTUxMTI0MTMyMjEwWjCBkDEoMCYGA1UEAwwfU2VsZlNpZ25lZENlcnRfMjROb3YyMDEzXzEzMjIwOTEYMBYGA1UECwwPMDBEYjAwMDAwMDBjNlNyMRcwFQYDVQQKDA5TYWxlc2ZvcmNlLmNvbTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzELMAkGA1UECAwCQ0ExDDAKBgNVBAYTA1VTQTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBALSrmK7aqDP+zBt8pbS7VnxqzhDqbrdmPx3temwsdYMMTG0UJZFnNs2+/FIZPe9Ab+zBFYBEb8pNDmg3GwSh+nXGWGZmuaGXH3qP8RTCL4/SFzF9G2up840i0QwtfuKddxVQKhDp+zRf9+FrQ1nFlhRf3luYVbdiTtO15VoD0CjnrKq8e8uJDZl6+zxdpYtrYEoF/mrMt85A3SR8YVAxjK7aZjJCiM/n9SMu905YbJ5r0Kbh21OqwZREQhNKhjNZ+7NrUib8N625SHSsutTIQ2ISEkMTYCvJrEcL+qzwDNnGUBG9y/RsYpL+/UudEXxJo4NLyWhD3Tm1CxozVxwsen8CAwEAAaOCAQAwgf0wHQYDVR0OBBYEFK05fBnMy1SU6Y/jB5QdwNabKTLLMIHKBgNVHSMEgcIwgb+AFK05fBnMy1SU6Y/jB5QdwNabKTLLoYGWpIGTMIGQMSgwJgYDVQQDDB9TZWxmU2lnbmVkQ2VydF8yNE5vdjIwMTNfMTMyMjA5MRgwFgYDVQQLDA8wMERiMDAwMDAwMGM2U3IxFzAVBgNVBAoMDlNhbGVzZm9yY2UuY29tMRYwFAYDVQQHDA1TYW4gRnJhbmNpc2NvMQswCQYDVQQIDAJDQTEMMAoGA1UEBhMDVVNBgg4BQopGR34AAAAAKy/hOTAPBgNVHRMBAf8EBTADAQH/MA0GCSqGSIb3DQEBBQUAA4IBAQCOBLz1MSRYhnQX/RJXoGQwzCtdV6ndSrP4igYx5TJpddqUQcQBtTbsUYkfH5RxjJhh9E8uFGU9YmqgeU+qKnIbGFXsxPPZVgHU8Plr/exbhWRlgaaP3+WGPk0LM+cd5ov6iXgrMYUq/QUDQrQite0moNXMMHyj+KJ3ZUb+qQm5Xex87gu8fXumR0KM8RKd0HcQ9j/c4tclVuFq6xlZrsBUr6X/2VeK03m7UTXwH18LOzAUiU9UUWOSlSGQScycaVVO/I5GYyoYGFBGhsgALre3j2zjnQbctCvZ15qeQ4nxIeCvaCCsjk2bVzY2yHDq7fGDJldjdu60NMGphkR4FgFy')),
			    						'SingleSignOnService'=>
			    						array(
				    						array(
				    							'Binding'=>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
				    							'Location'=>'https://tools4schools-dev-ed.my.salesforce.com/idp/endpoint/HttpPost'
				    							),
				    						array(
				    							'Binding'=>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
				    							'Location'=>'https://tools4schools-dev-ed.my.salesforce.com/idp/endpoint/HttpRedirect'
				    							),
				    						),
			    						),
								),
					'https://openidp.feide.no'=>
							array(
								'NameIDFormat'=>'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
								'Organization'=> array('OrganizationName'=>'Feide'),
								'IDPSSODescriptor' => 
			    					array(
										'KeyDescriptor' => array(array('use'=>'signing','key'=>'MIICizCCAfQCCQCY8tKaMc0BMjANBgkqhkiG9w0BAQUFADCBiTELMAkGA1UEBhMCTk8xEjAQBgNVBAgTCVRyb25kaGVpbTEQMA4GA1UEChMHVU5JTkVUVDEOMAwGA1UECxMFRmVpZGUxGTAXBgNVBAMTEG9wZW5pZHAuZmVpZGUubm8xKTAnBgkqhkiG9w0BCQEWGmFuZHJlYXMuc29sYmVyZ0B1bmluZXR0Lm5vMB4XDTA4MDUwODA5MjI0OFoXDTM1MDkyMzA5MjI0OFowgYkxCzAJBgNVBAYTAk5PMRIwEAYDVQQIEwlUcm9uZGhlaW0xEDAOBgNVBAoTB1VOSU5FVFQxDjAMBgNVBAsTBUZlaWRlMRkwFwYDVQQDExBvcGVuaWRwLmZlaWRlLm5vMSkwJwYJKoZIhvcNAQkBFhphbmRyZWFzLnNvbGJlcmdAdW5pbmV0dC5ubzCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAt8jLoqI1VTlxAZ2axiDIThWcAOXdu8KkVUWaN/SooO9O0QQ7KRUjSGKN9JK65AFRDXQkWPAu4HlnO4noYlFSLnYyDxI66LCr71x4lgFJjqLeAvB/GqBqFfIZ3YK/NrhnUqFwZu63nLrZjcUZxNaPjOOSRSDaXpv1kb5k3jOiSGECAwEAATANBgkqhkiG9w0BAQUFAAOBgQBQYj4cAafWaYfjBU2zi1ElwStIaJ5nyp/s/8B8SAPK2T79McMyccP3wSW13LHkmM1jwKe3ACFXBvqGQN0IbcH49hu0FKhYFM/GPDJcIHFBsiyMBXChpye9vBaTNEBCtU3KjjyG0hRT2mAQ9h+bkPmOvlEo/aH0xR68Z9hw4PF13w==')),
			    						'SingleSignOnService'=>
			    						array(
				    						array(
				    							'Binding'=>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
				    							'Location'=>'https://openidp.feide.no/simplesaml/saml2/idp/SSOService.php'
				    							),
				    						),
			    						),
								),
			    		'https://idp.tools4schools.org'=>
			    				array(
			    					'Organization'=>array('OrganizationName'=>'Tools4Schools'),
			    					'IDPSSODescriptor' => 
				    					array('SingleSignOnService'=>
				    						array(
					    						array(
					    							'Binding'=>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
					    							'Location'=>'https://openidp.feide.no/simplesaml/saml2/idp/SSOService.php'
					    							),
					    						),
				    						),		    					  
			    					),
			    		'http://sportal.tools4schools.ie'=>
			    				array(
			    					'Organization'=>array('OrganizationName'=>'Tools4Schools'),
			    					'KeyDescriptor'=>array(
			    						),
			    					'SPSSODescriptor'=> 
			    						array('AssertionConsumerService'=>
			    							array(
			    								array(
			    									'Binding'=>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
			    									'Location'=>'http://portal.tools4schools.ie/login/AssertionConsumingService'
			    									),
			    								array(
			    									'Binding'=>'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
			    									'Location'=>'http://portal.tools4schools.ie/login/AssertionConsumingService'
			    									),
			    								),

			    							),
			    					),
    						),
					
);