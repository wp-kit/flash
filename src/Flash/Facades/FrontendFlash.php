<?php

	namespace WPKit\Flash\Facades;
	
	class FrontendFlash extends Flash {
		
	    /**
	     * Get the registered name of the component.
	     *
	     * @return string
	     */
	    protected static function getFacadeAccessor()
	    {
	        return 'frontendFlash';
	    }
	    
	}