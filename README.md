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
* Oauth V2 Authentication
* SAML V2 Authentication
* LDAP (ActiveDirectory) 
* OpenID
* Yubii Key

because of the driver based design additional authentication protocols can be easily added 

## installation
=================

Installation of Camelot-Auth is quite simple. but just in case we have created a number of tutorials to help you get CamelotAuth up and running in no time

1. installing for [Laravel 4] (http://support.twsweb-int.com/projects/camelot/docs/installation/laravel4)
2. native install  (http://support.twsweb-int.com/projects/camelot/docs/installation/native) 

##To Do 
==================

* fix csrf in oauth2client Driver
* fix problem with IlluminateCookie
* fix problem with IlluminateSession
