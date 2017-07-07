<?php
	
	use Illuminate\Container\Container;
	
	if (!function_exists('app')) {
	    /**
	     * Helper function to quickly retrieve an instance.
	     *
	     * @param null  $abstract   The abstract instance name.
	     * @param array $parameters
	     *
	     * @return mixed
	     */
	    function app($abstract = null, array $parameters = [])
	    {
	        if (is_null($abstract)) {
	            return Container::getInstance();
	        }
	        return Container::getInstance()->make($abstract, $parameters);
	    }
	}

	if (! function_exists('session')) {
	    /**
	     * Get / set the specified session value.
	     *
	     * If an array is passed as the key, we will assume you want to set an array of values.
	     *
	     * @param  array|string  $key
	     * @param  mixed  $default
	     * @return mixed
	     */
	    function session($key = null, $default = null)
	    {
	        if (is_null($key)) {
	            return app('session');
	        }
	        if (is_array($key)) {
	            return app('session')->put($key);
	        }
	        return app('session')->get($key, $default);
	    }
	}
	
	if ( ! function_exists('notifier') ) {
	    /**
	     * Gets the notifier object
	     *
	     * @param  string $key
	     * @return \WPKit\Notifications\Notifiers\Notifier
	     */
	    function notifier($notifier = 'frontend')
	    {
	        return app($notifier.'Notifier');
	    }
	}