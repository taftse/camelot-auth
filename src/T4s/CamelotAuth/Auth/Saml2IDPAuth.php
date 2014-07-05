<?php
/**
 * Camelot Auth
 *
 * @author Timothy Seebus <timothyseebus@tools4schools.org>
 * @license http://opensource.org/licences/MIT
 * @package CamelotAuth
 */
namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Auth\Saml2\Bindings\Binding;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\Assertion;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\AuthnStatement;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\Conditions;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\SubjectConfirmation;
use T4s\CamelotAuth\Auth\Saml2\Core\Elements\SubjectConfirmationData;
use T4s\CamelotAuth\Auth\Saml2\Core\Messages\AuthnRequest;
use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\EndpointType;
use T4s\CamelotAuth\Auth\Saml2\Saml2Auth;
use T4s\CamelotAuth\Auth\Saml2\Saml2Constants;

use T4s\CamelotAuth\Auth\Saml2\Saml2State;

use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;

use T4s\CamelotAuth\Events\DispatcherInterface;

use T4s\CamelotAuth\Auth\Saml2\Metadata\Elements\IndexedEndpointType;


class Saml2IDPAuth extends Saml2Auth implements AuthInterface
{


	public $supportedBindings = [Saml2Constants::Binding_HTTP_POST];



	public function authenticate(array $credentials = null, $remember = false,$login = true)
	{
		// check if a idp entity id is set in the credentails
		if(isset($credentials['entityID']))
		{
			// override the provider
			$this->provider = $credentials['entityID'];
		}
		// check if the entity provider is valid
		
		if(strpos($this->path,'SingleLogoutService'))
		{
			//return $this->handleSingleLogoutRequest();
		}
		else if(strpos($this->path,'SingleSignOnService'))
		{
			return $this->handleAuthnRequest();
		}

		//return $this->handleNewSSORequest();
	}

    protected function handleAuthnRequest()
    {
        $binding = Binding::getBinding();

        $requestMessage = $binding->receive();

        if(!($requestMessage instanceof AuthnRequest))
        {
            throw new \Exception('Wrong message type recieved exspecting an AuthnRequest Message');
        }


        if(!$this->metadataStore->isValidEnitity($requestMessage->getIssuer()))
        {
            throw new \Exception('unknown EntityID : this IDP does not have a trust relationship with entityID '.$requestMessage->getIssuer());
        }

        $state = new Saml2State($requestMessage);


        if($requestMessage->getForceAuthn())
        {
            // we need to (re)authenticate the user


            // redirect to login uri
            $state->setAttribute('forceAuth',true);
            // send with a state object containing redirect to url,method and request message
            $state->setCallaback($this,'sendResponse');

        }
        else if($this->check() == false)
        {

        }

        $this->sendResponse($state);
    }

    public function sendResponse(Saml2State $state)
    {
        $acsEndpoint = $this->getEndpoint('AssertionConsumerService');
        // create assertion
        $message = $this->createAssertion($state,$acsEndpoint);

        $acsEndpoint->send($message);
    }

    public function createAssertion(Saml2State $state,EndpointType $acsEndpoint)
    {
        //if sp wants assertions signed sign the assertion
        $assertion = new Assertion();
        $assertion->setIssuer($this->provider);

        $condition = new Conditions();
        $condition->setValidAudience([$state->getMessage()->getIssuer()]);
        $condition->setNotBefore(time() -30);
        $condition->setNotOnOrAfter(time() + $this->config->get('saml2.assertionLifetime'));

        $assertion->addConditions($condition);

        $authnStatement = new AuthnStatement();
        $authnStatement->setAuthnContext(Saml2Constants::AuthnContext_Password);
        if(!is_null($state->getMessage()->getRequestedAuthnContext()))
        {
            $authnStatement->setAuthnContext($state->getMessage()->getRequestedAuthnContext());
        }
        $authnStatement->setSessionNotOnOrAfter(time()+ $this->config->get('sessionLifetime') * 60);

        $assertion->addAuthnStatement($authnStatement);

        $subjectConfirmation = new SubjectConfirmation();
        $subjectConfirmationData = new SubjectConfirmationData();
        $subjectConfirmationData->setNotOnOrAfter(time() + $this->config->get('saml2.assertionLifetime'));
        $subjectConfirmationData->setRecipient($acsEndpoint->getLocation());
        $subjectConfirmationData->setInResponseTo($state->getMessage()->getID());

        if($acsEndpoint->getBinding() === Saml2Constants::Binding_HOK_SSO)
        {
            $subjectConfirmation->setMethod(Saml2Constants::SubjectConfirmation_HolderOfKey);

            //@todo complete HOK Code
        }else{
            $subjectConfirmation->setMethod(Saml2Constants::SubjectConfirmation_Bearer);
        }

        $assertion->addSubjectConfirmation($subjectConfirmation);


        // add attributes
        $attributes = $this->getAttributes($state->getMessage()->getIssuer());

        // set nameID



    }

    protected function getAttributes($entityID)
    {
        $entity = $this->metadataStore->getEntityDescriptor($entityID);
        var_dump($entity);
        //$this->attributeResolver->getAttributes);
    }

    protected function getEndpoint($endpointType,$url = null,$binding = null,$index = null)
    {
        $supportedBindings = [];
        $firstFalse = null;
        $firstNotFalse = null;

        $idpMetadata = $this->metadataStore->getEntityDescriptor($this->config->get('saml2.myEntityID'));

            foreach($idpMetadata->getEndpoints($endpointType) as $endpoint)
            {
                $supportedBindings = $endpoint->getBinding();
            }

        $spMetadata  = $this->metadataStore->getEntityDescriptor($this->provider);
        foreach($spMetadata->getEndpoints($endpointType) as $endpoint)
        {
            if(!is_null($url) && $endpoint->getLocation() !== $url)
            {
                continue;
            }

            if(!is_null($binding) && $endpoint->getBinding() !== $binding)
            {
                continue;
            }


            if(!is_null($index) && $endpoint instanceof IndexedEndpointType && $endpoint->getIndex() !== $index)
            {
                continue;
            }

            if(!in_array($endpoint->getBinding(),$supportedBindings,TRUE))
            {
                continue;
            }

            if($endpoint->hasDefault())
            {
                if($endpoint->isDefault())
                {
                    return $endpoint;
                }

                if(is_null($firstFalse))
                {
                    $firstFalse = $endpoint;
                }
            }else if(is_null($firstNotFalse)){
                $firstNotFalse = $endpoint;
            }

        }

        if(!is_null($firstNotFalse))
        {
            return $firstNotFalse;
        }
        else if(!is_null($firstFalse))
        {
            return $firstFalse;
        }

        return $spMetadata->getDefaultEndpoint($endpointType,$supportedBindings);
    }
}