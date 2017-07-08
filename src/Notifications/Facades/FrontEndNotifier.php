<?php

	namespace WPKit\Notifications\Facades;
	
	use Illuminate\Support\Facades\Facade;
	
	class FrontEndNotifier extends Facade {
		
	    /**
	     * Get the registered name of the component.
	     *
	     * @return string
	     */
	    protected static function getFacadeAccessor()
	    {
	        return 'frontEndNotifier';
	    }
	    
	}