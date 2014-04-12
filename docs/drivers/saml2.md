### Setting up an SAML2

camelot auth can be used as both a saml2 Service provider (SP) and Identity Provider (IDP)



sp endpoints 

/								Sends a AuthnRequest To the IDP privided in the url or the authentication credentials 
/AssertionConsumingService		handles a AssertionConsumingService response from any IDP 
/SingleLogoutService			handles a SingleLogoutService Request from any IDP


idp endpoints

/								handles a AuthnRequest from any SP 
/
/SingleLogoutRequest			sends a SingleLogoutRequest to specified SP