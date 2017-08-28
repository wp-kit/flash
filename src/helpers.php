<?php
	
	if ( ! function_exists('flash') ) {
		
	    /**
	     * Gets the notifier object
	     *
	     * @param  string $flasher
	     * @return \WPKit\Flash\Flashers\Flash
	     */
	    function flash($flasher = 'frontend')
	    {
	        return app($flasher.'Flash');
	    }
		
	}
