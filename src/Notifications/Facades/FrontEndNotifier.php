<?php

	namespace WPKit\Notifications\Facades;
	
	class FrontendNotifier extends Facade {
		
	    /**
	     * Get the registered name of the component.
	     *
	     * @return string
	     */
	    protected static function getFacadeAccessor()
	    {
	        return 'frontendNotifier';
	    }
	    
	}