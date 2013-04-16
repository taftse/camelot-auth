#Camelot-Auth
============

[![Build Status](https://travis-ci.org/taftse/camelot-auth.png?branch=master)](https://travis-ci.org/taftse/camelot-auth)

Camelot auth is A Modular based Authentication library



## Instalation

Camelot-Auth is provided as a Composer package which can be installed by adding the package to your composer.json file:

```javascript
{
	"require": {
		"twsweb-int/camelot-auth": "*"
	}
}
```
## Currently Supported Authentication Protocols
==================
Camelot Auth (will) support the following authentication protocols 

* Local(form) Authentication
* Oauth V1 Authentication
    * Twitter
* Oauth V2 Authentication
    * Facebook
    * Google
    * Youtube
    * GitHub
    * Windows Live
* Oauth V2 Server Authentication
* SAML V2 Authentication
* LDAP (ActiveDirectory) 
* OpenID
* Yubii Key

because of the driver based design additional authentication protocols can be easily added 

## installation
=================

Installation of Camelot-Auth is quite simple. but just in case we have created a number of tutorials to help you get Camelot-Auth up and running in no time

1. [Laravel 4 Installation] (https://github.com/taftse/camelot-auth/wiki/Laravel-4-Instalation)
2. [Native Installation]  (http://support.twsweb-int.com/projects/camelot/docs/installation/native) 

## Usage
=================

* [User Authentication] (https://github.com/taftse/camelot-auth/wiki/Authentication)
* [User Logout] (https://github.com/taftse/camelot-auth/wiki/Login)

##To Do 
==================

* fix csrf in oauth2client Driver
* fix problem with IlluminateCookie
* fix problem with IlluminateSession
