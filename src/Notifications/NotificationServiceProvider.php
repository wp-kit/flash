<?php

namespace WPKit\Notifications;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use WPKit\Session\Middleware\StartSession;
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
    
    /**
	* Boot the service provider
	*
	* @return void
	*/
	public function boot() {
		
		$this->publishes([
			__DIR__.'/../../views/notifiers/frontend.twig' => view_path('notifiers/frontend.twig')
		], 'views');
		
		$this->publishes([
			__DIR__.'/../../views/notifiers/admin.twig' => view_path('notifiers/admin.twig')
		], 'views');
		
	}
    	
}
