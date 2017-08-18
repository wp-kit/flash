<?php

	namespace WPKit\Flash\Facades;
	
	class AdminFlash extends Flash {
		
	    /**
	     * Get the registered name of the component.
	     *
	     * @return string
	     */
	    protected static function getFacadeAccessor()
	    {
	        return 'adminFlash';
	    }
	    
	}