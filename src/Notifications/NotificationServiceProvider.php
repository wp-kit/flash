<?php

namespace WPKit\Notifications;

use Illuminate\Support\ServiceProvider;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use WPKit\Notifications\Notifiers\FrontEndNotifier;
use WPKit\Notifications\Notifiers\AdminNotifier;

class NotificationServiceProvider extends ServiceProvider
{
    
    /**
     * Register the instance.
     *
     * @return void
     */
    public function register()
    {
		
		$this->app->instance(
            'frontendNotifier',
            $this->app->make(FrontEndNotifier::class)
        );
        
        $this->app->instance(
            'adminNotifier',
            $this->app->make(AdminNotifier::class)
        );
			
		Route::aliasMiddleware('web.session', StartSession::class);
		
		$this->app['view.finder']->addLocation($this->defaultPath('views'));
        
    }
    
    public function defaultPath( $path = '', $file = '' ) {
	    
	    return WPKIT_NOTIFICATIONS_RESOURCES . DS . ( $path ? $path . DS : '' ) . ( $file ? $file : '' );
	    
    }
    	
}
