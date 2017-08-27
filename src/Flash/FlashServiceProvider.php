<?php

namespace WPKit\Flash;

use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
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
        
        // These actions act as Kernel management of Session Middleware
        add_action( 'admin_init', [$this, 'startSession'] );
        add_action( 'admin_print_footer_scripts', [$this, 'terminateSession'] );
        
    }
    
    /**
     * Start Session for Wp Admin
     *
     * return void
     */
    public function startSession() {
	    
	    $session = $this->app->make(StartSession::class);
	    $request = Input::getFacadeRoot();
	    
	    return tap($session->getSession($request), function ($session) use($request) {
            $session->setRequestOnHandler($request);
            $session->start();
        });
	    
    }
    
    /**
     * Write to Session (via Session Terminate)
     *
     * return void
     */
    public function terminateSession() {
	    	    
	    $session = $this->app->make('session');
	    
	    $session->driver()->save();
	    
    }
    	
}
