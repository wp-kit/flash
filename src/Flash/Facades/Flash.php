<?php

	namespace WPKit\Flash\Facades;
	
	use Illuminate\Support\Facades\Facade;
	
	class Flash extends Facade {
		
	    /**
	     * Print the notifications
	     *
	     * @return view
	     */
	    public static function print()
	    {
	        return static::$app[static::getFacadeAccessor()]->print();
	    }
	    
	}