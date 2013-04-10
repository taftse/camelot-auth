### Installing in Laravel 4 (with Composer)

##### Step 1
Start by adding "twsweb-int/camelot-auth": "*" to the require attribute in your composer.json file.

```javascript
{
	"require": {
		"twsweb-int/camelot-auth": "*"
	}
}
```

##### Step 2
Run `php composer.phar update` from the command line  

##### Step 3
Add `'TwswebInt\CamelotAuth\CamelotAuthServiceProvider'` to the `providers` array in app/config/app.php

##### Step 4 *(optional)*
Add `'Camelot' => 'TwswebInt\CamelotAuth\Facades\Camelot',` to the `aliases` array also in app/config/app.php