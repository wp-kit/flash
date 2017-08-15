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
    Illuminate\Filesystem\FilesystemServiceProvider::class, // specify the driver provider
    Illuminate\Session\SessionServiceProvider::class, // you need this too, if Non-Themosis
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

// DRIVER

$provider = new Illuminate\Filesystem\FilesystemServiceProvider($container); // inject into service provider

$provider->register(); //register service provider

// SESSION

$provider->register(); //register service provider

$provider = new Illuminate\Session\SessionServiceProvider($container); // Non-Themosis
//$provider = new WPKit\Session\SessionServiceProvider($container); // Themosis

$provider->register(); //register service provider

// NOTIFICATIONS

$provider = new WPKit\Notifications\NotificationServiceProvider($container); // inject into service provider

$provider->register(); //register service provider
```
## Config

Although a config file is not required for ```wp-kit/notifications```, one is needed for your SessionProvider.

If you are using Themosis, you should [publish the config file](https://github.com/wp-kit/session#config) for ```wp-kit/session```.

If you are not using Themosis, you should publish the [default config file](https://github.com/laravel/laravel/blob/master/config/session.php) from Laravel and customise it accordingly. 

## How to Use

> **Note:** AdminNotifier automatically outputs notices in admin area using the hook ```admin_notices```

### Using Facades

```php
// Just in case you need to include the Facade in a custom namespace

use WPKit\Notifications\Facades\AdminNotifier;
use WPKit\Notifications\Facades\FrontendNotifier;

// Frontend

FrontendNotifier::success('Well done!');
FrontendNotifier::warning('Hmm, not sure about that...');
FrontendNotifier::error('What on earth are you doing?');

$messages = FrontendNotifier::all();

$html = FrontendNotifier::render();

$chained = FrontendNotifier::success('Well done!')->render();

FrontendNotifier::clear();

FrontendNotifier::print([
	'message' => 'Ooh, living dangerously are we?'
	'class' => 'some-classname'
]);

// Admin

AdminNotifier::success('Well done!');
AdminNotifier::warning('Hmm, not sure about that...');
AdminNotifier::error('What on earth are you doing?');

$messages = AdminNotifier::all();

$html = AdminNotifier::render();

$chained = AdminNotifier::success('Well done!')->render();

AdminNotifier::clear();

AdminNotifier::print([
	'message' => 'Ooh, living dangerously are we?'
	'class' => 'some-classname'
]);
```

### Using Helper Function

```php
// Frontend

notifier('frontend')->success('Well done!');
notifier('frontend')->warning('Hmm, not sure about that...');
notifier('frontend')->error('What on earth are you doing?');

$messages = notifier('frontend')->all();

$html = notifier('frontend')->render();

$chained = notifier('frontend')->success('Well done!')->render();

notifier('frontend')->clear();

notifier('frontend')->print([
	'message' => 'Ooh, living dangerously are we?'
	'class' => 'some-classname'
]);

// Admin

notifier('admin')->success('Well done!');
notifier('admin')->warning('Hmm, not sure about that...');
notifier('admin')->error('What on earth are you doing?');

$messages = notifier('admin')->all();

$html = notifier('admin')->render();

$chained = notifier('admin')->success('Well done!')->render();

notifier('admin')->clear();

notifier('admin')->print([
	'message' => 'Ooh, living dangerously are we?'
	'class' => 'some-classname'
]);
```

## Views

### Installation

The recommended method of installing view files for ```wp-kit/notifications``` is via ```wp-kit/vendor-publish``` command.

First, [install WP CLI](http://wp-cli.org/), and then install the package via:

```wp package install wp-kit/vendor-publish```

Once installed you can run:

```wp kit vendor:publish```

For more information, please visit [wp-kit/vendor-publish](https://github.com/wp-kit/vendor-publish).

Alternatively, you can place the [view file(s)](views) in your ```theme/resources/views``` directory manually.

### Looping through messages

This is just a guide of how you use use ```wp-kit/notifications``` when looping through a load of messages where you need to output markup around each notification:

```html

// within theme/resources/views/some-view.php

<div class="row">

	<?php foreach( notifier('frontend')->all() as $message ) : ?>
	
		<div class="column">
		
			<?php notifier( 'frontend' )->print( $message ); ?>
			
		</div>
		
	<?php endforeach; ?>
	
</div>
```

## Requirements

Wordpress 4+

PHP 5.6+

## License

WPKit Notifications is open-sourced software licensed under the MIT License.
