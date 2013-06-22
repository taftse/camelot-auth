### Authenticate a user (by detecting the authentication provider)

in this instanece camelot auth expects the url to contain the name of authentication provider you want to call for example 
`http://www.domain.com/login/facebook` 
will call the `login` page and call the `oauth2` driver with the settings for the `facebook` authentication provider

----------------------------------
#### Example 

```php
	try
	{
		Camelot::authenticate();

		if(Camelot::check()){
			echo 'Welcome'.Camelot::User()->first_name.' '.Camelot::User()->last_name.' you have been successfully logged in';
		}
	}
	catch(\Exception $e)
	{
			echo 'user could not be logged in';
	}

```

### Authenticate a user (by specifying the auhentication provider)

in this instanec you will specify the required driver and authentication provider 
and then try to authenticate 

----------------------------------
#### Example

```php
	try
	{
		Camelot::loadDriver('oauth2client','facebook');
		Camelot::authenticate();

		if(Camelot::check()){
			echo 'Welcome'.Camelot::User()->first_name.' '.Camelot::User()->last_name.' you have been successfully logged in';
		}
	}
	catch(\Exception $e)
	{
			echo 'user could not be logged in';
	}
```
----------------------------------
### Authenticate a user (by providing credentials)

some drivers (such as the form driver) expect credentials to be provided to be able to authenticate a user 

----------------------------------

#### Example

```php
	try
	{
		// lets specify the local form authentication driver
		Camelot::loadDriver('local');

		$credentials = array('username'=>'taftse','password'=>'Excalibur')

		Camelot::authenticate($credentials);

		if(Camelot::check()){
			echo 'Welcome'.Camelot::User()->first_name.' '.Camelot::User()->last_name.' you have been successfully logged in';
		}
		
	}
	catch(\Exception $e)
	{
			echo 'user could not be logged in';
	}
```
----------------------------------
