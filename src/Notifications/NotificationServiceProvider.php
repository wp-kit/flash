<?php

namespace WPKit\Notifications;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use WPKit\Session\Middleware\StartSession;
use WPKit\Notifications\Facades\Facade;
use WPKit\Notifications\Notifiers\FrontendNotifier;
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
	    
	    Facade::setFacadeApplication($this->app);
		
		$this->app->instance(
            'frontendNotifier',
            $this->app->make(FrontendNotifier::class)
        );
        
        $this->app->instance(
            'adminNotifier',
            $this->app->make(AdminNotifier::class)
        );
			
		Route::aliasMiddleware('web.session', StartSession::class);
        
    }
    	
}
