<?php

	namespace WPKit\Flash\Facades;
	
	use Illuminate\Support\Facades\Facade;
	
	class Flash extends Facade {
		
	    /**
	     * Print the notifications
	     *
	     * @return view
	     */
	    public static function display()
	    {
	        return static::$app[static::getFacadeAccessor()]->display();
	    }
	    
	}
