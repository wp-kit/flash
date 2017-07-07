<?php

namespace WPKit\Notifications;

use Illuminate\Support\ServiceProvider;
use Illminate\Session\SessionServiceProvider;
use WPKit\Notifications\Facades\Facade;
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
	    
	    if( ! $this->app->bound( 'session' ) ) {
	    
	    	$provider = new SessionServiceProvider($this->app);
	    
			$provider->register();
			
		}
		
		Facade:setFacadeApplication($this->app);
        
        $this->app->instance(
            'frontendNotifier',
            $this->app->make(FrontEndNotifier::class)
        );
        
        $this->app->instance(
            'adminNotifier',
            $this->app->make(AdminNotifier::class)
        );
        
    }
    
}
