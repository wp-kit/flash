<?php

	namespace WPKit\Notifications\Facades;
	
	use Illuminate\Support\Facades\Facade as BaseFacade;
	
	class Facade extends BaseFacade {
		
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