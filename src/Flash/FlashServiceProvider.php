<?php

namespace WPKit\Flash;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use WPKit\Session\Middleware\StartSession;
use WPKit\Flash\Facades\Flash;
use WPKit\Flash\Flashers\FrontendFlash;
use WPKit\Flash\Flashers\AdminFlash;

class FlashServiceProvider extends ServiceProvider
{
    
    /**
     * Register the instance.
     *
     * @return void
     */
    public function register()
    {
	    
	    Flash::setFacadeApplication($this->app);
		
		$this->app->instance(
            'frontendFlash',
            $this->app->make(FrontendFlash::class)
        );
        
        $this->app->instance(
            'adminFlash',
            $this->app->make(AdminFlash::class)
        );
			
		Route::aliasMiddleware('web.session', StartSession::class);
        
    }
    	
}
