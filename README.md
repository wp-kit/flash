# WPKit Notifications

This is a Wordpress PHP Component that handles both Frontend and Admin Notifications.

This PHP Component was built to run within an Illuminate Container so is perfect for frameworks such as Themosis.

Often, Wordpress developers want to be able to use a single component the handle notifications stored in the session and their output to the client, usually after a redirect. 

In Wordpress we do have the ability to forge admin notices via some hooks but there a few hoops to jump through in that you have to write quite a bit of code to handle the session storage and the output, and currently there are no hooks for front-end notifications.

## Installation

If you're using Themosis, install via composer in the Themosis route folder, otherwise install in your theme folder:

```php
composer require "wp-kit/notifications"
```

## Registering Service Provider & Facades

**Within Themosis Theme**

Just register the service provider and facade in the providers config and theme config:

```php
//inside themosis-theme/resources/config/providers.config.php

return [
    //
    Illuminate\Session\SessionServiceProvider::class, // you need this too, if non-Themosis
    //WPKit\Session\SessionServiceProvider::class, // use this if Themosis
    WPKit\Notifications\NotificationServiceProvider::class
];
```

```php
//inside themosis-theme/resource/config/theme.config.php

'aliases' => [
    //
    'AdminNotifier' => WPKit\Notifications\Facades\AdminNotifier::class,
    'FrontendNotifier' => WPKit\Notifications\Facades\FrontendNotifier::class
    //
]
```

### Config

Although a config file is not required for ```wp-kit/notifications```, one is needed for your SessionProvider.

If you are using Themosis, you should [publish the config file](https://github.com/wp-kit/session#config) for ```wp-kit/session```.

If you are not using Themosis, you should publish the [default config file](https://github.com/laravel/laravel/blob/master/config/session.php) from Laravel and customise it accordingly. 

**Within functions.php**

If you are just using this component standalone then add the following the functions.php

```php
// within functions.php

// make sure composer has been installed
if( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	
	wp_die('Composer has not been installed, try running composer', 'Dependancy Error');
	
}

// Use composer to load the autoloader.
require __DIR__ . '/vendor/autoload.php';

$container = new Illuminate\Container\Container(); // create new app container

$provider = new Illuminate\Session\SessionServiceProvider($container); // inject into service provider

$provider->register(); //register service provider

$provider = new WPKit\Notifications\NotificationServiceProvider($container); // inject into service provider

$provider->register(); //register service provider
```

## Using Notifiers

WPKit Notifications are pretty flexible. You can use them anywhere but ideally you should use them in your Controllers. You can use the Facade or the Helper functions:

```php

use WPKit\Notifications\Facades\AdminNotifier;
use WPKit\Notifications\Facades\FrontendNotifier;

// as php function as below

// using facade


```

## Handling the Output

```php

<some>

	<html></html>
	
</some>


```

## Requirements

Wordpress 4+

PHP 5.6+

## License

WPKit Notifications is open-sourced software licensed under the MIT License.
