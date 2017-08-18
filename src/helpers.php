<?php
	
	if ( ! function_exists('notifier') ) {
	    /**
	     * Gets the notifier object
	     *
	     * @param  string $notifier
	     * @return \WPKit\Notifications\Notifiers\Notifier
	     */
	    function notifier($notifier = 'frontend')
	    {
	        return app($notifier.'Notifier');
	    }
		
	}
