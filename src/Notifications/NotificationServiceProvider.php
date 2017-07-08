<?php

namespace WPKit\Notifications;

use Illuminate\Support\ServiceProvider;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\View\ViewServiceProvider;
use WPKit\Notifications\Facades\Facade;
use WPKit\Notifications\Notifiers\FrontEndNotifier;
use WPKit\Notifications\Notifiers\AdminNotifier;
use Themosis\Finder\FinderException;

class NotificationServiceProvider extends ServiceProvider
{
    
    /**
     * Register the instance.
     *
     * @return void
     */
    public function register()
    {
		
		$this->registerConfig();
		
		$this->registerFilesystem();
			
		$this->registerSession();
		
		$this->registerView();
		
		$this->registerNotifiers();
		
		Facade::setFacadeApplication($this->app);
		
		Route::middleware('session', StartSession::class);
        
    }
    
    public function defaultPath( $path = '', $file = '' ) {
	    
	    return WPKIT_NOTIFICATIONS_RESOURCES . DS . ( $path ? $path . DS : '' ) . ( $file ? $file : '' );
	    
    }
    
    /**
     * Register config
     *
     * @return void
     */
    public function registerConfig()
    {
    
    	if( isset( $GLOBALS['themosis'] ) ) {
			
			$this->app['config.finder']->addPaths([
				$this->defaultPath('config')
			]);
			
		} else {

			$theme_path = config_path('session.config.php');
			
			if( file_exists( $theme_path ) ) {
				
				$config = include $theme_path;
				
			} else {
				
				$config = include $this->defaultPath('config', 'session.php');
				
			}
			
			$this->app['config']->set('session', $config);
			
		}
		
	}
	
	/**
     * Register filesystem
     *
     * @return void
     */
    public function registerFilesystem()
    {
    
    	if( ! $this->app->bound( 'files' ) ) {
			
			$provider = new FilesystemServiceProvider($this->app);
			
			$provider->register();
			
		}
		
	}
	
	/**
     * Register session
     *
     * @return void
     */
    public function registerSession()
    {
    
    	if( ! $this->app->bound( 'session' ) ) {
	    
	    	$provider = new SessionServiceProvider($this->app);
	    
			$provider->register();
			
		}
		
	}
	
	/**
     * Register view
     *
     * @return void
     */
    public function registerView()
    {
    
    	if( ! $this->app->bound( 'view' ) ) {
	    
	    	$provider = new ViewServiceProvider($this->app);
	    
			$provider->register();
			
			$this->app['view.finder']->addLocation(view_path() . DS);
			
		}
		
		$this->app['view.finder']->addLocation($this->defaultPath('views'));
		
	}
	
	/**
     * Register notifiers
     *
     * @return void
     */
    public function registerNotifiers()
    {
    
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
