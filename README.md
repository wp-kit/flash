# wp-kit/flash

This is a Wordpress PHP Component that handles both Frontend and Admin Flashes.

This PHP Component was built to run within an Illuminate Container so is perfect for frameworks such as Themosis.

Often, Wordpress developers want to be able to use a single component the handle flashes stored in the session and their output to the client, usually after a redirect. 

In Wordpress we do have the ability to forge admin notices via some hooks but there a few hoops to jump through in that you have to write quite a bit of code to handle the session storage and the output, and currently there are no hooks for front-end flashes.

## Installation

If you're using ```Themosis```, install via composer in the Themosis route folder, otherwise install in your theme folder:

```php
composer require "wp-kit/flash"
```

## Setup

### Add Service Provider

**Within Themosis Theme**

Just register the service provider and facade in the providers config and theme config:

```php
//inside themosis-theme/resources/config/providers.config.php

return [
    //
    Illuminate\Filesystem\FilesystemServiceProvider::class, // specify the driver provider
    Illuminate\Session\SessionServiceProvider::class, // you need this too, if Non-Themosis
    //WPKit\Session\SessionServiceProvider::class, // use this if Themosis
    WPKit\Flash\FlashServiceProvider::class
];
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

// FLASHES

$provider = new WPKit\Flash\FlashServiceProvider($container); // inject into service provider

$provider->register(); //register service provider
```

### Add Facade (Themosis Only)

```php
//inside themosis-theme/resource/config/theme.config.php

'aliases' => [
    //
    'AdminFlash' => WPKit\Flash\Facades\AdminFlash::class,
    'FrontendFlash' => WPKit\Flash\Facades\FrontendFlash::class
    //
]
```

### Add Config & View File(s)

Although a config file is not required for ```wp-kit/flash```, we do need to publish view files and a config is needed for your ```SessionProvider```.

The recommended method of installing view files for ```wp-kit/flash``` is via ```wp-kit/vendor-publish``` command.

First, [install WP CLI](http://wp-cli.org/), and then install the package via:

```wp package install wp-kit/vendor-publish```

Once installed you can run:

```wp kit vendor:publish```

For more information, please visit [wp-kit/vendor-publish](https://github.com/wp-kit/vendor-publish).

Alternatively, you can place the [view file(s)](views) in your ```theme/resources/views``` directory manually.

If you are using ```Themosis```, you should [publish the config file](https://github.com/wp-kit/session#add-config-file) for ```wp-kit/session```.

If you are not using ```Themosis```, you should publish the [default config file](https://github.com/laravel/laravel/blob/master/config/session.php) from Laravel and customise it accordingly. 

## Usage

> **Note:** ```AdminFlash``` automatically outputs notices in admin area using the hook ```admin_notices```

> **Important** Don't forget to use the [```Illuminate\Session\MiddlewareStartSession```](https://github.com/illuminate/session/blob/master/Middleware/StartSession.php) middleware to ensure flashes persist. If you are using ```wp-kit/session``` then you can use the alias middleware set on [```web.session```](https://github.com/wp-kit/session#using-middleware).

### Using Facades

```php
// Just in case you need to include the Facade in a custom namespace

use WPKit\Flash\Facades\AdminFlash;
use WPKit\Flash\Facades\FrontendFlash;

// Frontend

FrontendFlash::success('Well done!');
FrontendFlash::warning('Hmm, not sure about that...');
FrontendFlash::error('What on earth are you doing?');

$messages = FrontendFlash::all();

$html = FrontendFlash::render();

$chained = FrontendFlash::success('Well done!')->render();

FrontendFlash::clear();

FrontendFlash::print([
	'message' => 'Ooh, living dangerously are we?'
	'class' => 'some-classname'
]);

// Admin

AdminFlash::success('Well done!');
AdminFlash::warning('Hmm, not sure about that...');
AdminFlash::error('What on earth are you doing?');

$messages = AdminFlash::all();

$html = AdminFlash::render();

$chained = AdminFlash::success('Well done!')->render();

AdminFlash::clear();

AdminFlash::print([
	'message' => 'Ooh, living dangerously are we?'
	'class' => 'some-classname'
]);
```

### Using Helper Function

```php
// Frontend

flash('frontend')->success('Well done!');
flash('frontend')->warning('Hmm, not sure about that...');
flash('frontend')->error('What on earth are you doing?');

$messages = flash('frontend')->all();

$html = flash('frontend')->render();

$chained = flash('frontend')->success('Well done!')->render();

flash('frontend')->clear();

flash('frontend')->print([
	'message' => 'Ooh, living dangerously are we?'
	'class' => 'some-classname'
]);

// Admin

flash('admin')->success('Well done!');
flash('admin')->warning('Hmm, not sure about that...');
flash('admin')->error('What on earth are you doing?');

$messages = flash('admin')->all();

$html = flash('admin')->render();

$chained = flash('admin')->success('Well done!')->render();

flash('admin')->clear();

flash('admin')->print([
	'message' => 'Ooh, living dangerously are we?'
	'class' => 'some-classname'
]);
```

### Looping through messages

This is just a guide of how you use use ```wp-kit/flash``` when looping through a load of flashes where you need to output markup around each flash:

```html

// within theme/resources/views/some-view.php

<div class="row">

	<?php foreach( flash('frontend')->all() as $message ) : ?>
	
		<div class="column">
		
			<?php flash( 'frontend' )->print( $message ); ?>
			
		</div>
		
	<?php endforeach; ?>
	
</div>
```

## Requirements

Wordpress 4+

PHP 5.6+

## License

wp-kit/flash is open-sourced software licensed under the MIT License.
