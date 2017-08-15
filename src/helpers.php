<?php
	
	use Illuminate\Container\Container;
	
	if( ! defined( 'DS' ) ) {
		
		define( 'DS', DIRECTORY_SEPARATOR );
		
	} 
	
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
	     * @param  string $notifier
	     * @return \WPKit\Notifications\Notifiers\Notifier
	     */
	    function notifier($notifier = 'frontend')
	    {
	        return app($notifier.'Notifier');
	    }
	}
	
	if( ! function_exists('resources_path') ) {
		/**
	     * Gets the resources path
	     *
	     * @return string
	     */
	    function resources_path($path = '', $file = '')
	    {
		    if( function_exists('themosis_path') && ! empty( $GLOBALS['themosis.paths']['theme'] ) ) {
			    $path = themosis_path('theme.resources' . ( $path ? '.' . $path : '' ));
		    } else {
			    $path = get_stylesheet_directory() . DS . 'resources' . ( $path ? DS . $path : '' );
		    }
		    return $path . ltrim( ( $file ? DS . $file : '' ), DS );
	    }
	}
	
	if( ! function_exists('storage_path') ) {
		/**
	     * Gets the storage path
	     *
	     * @return string
	     */
	    function storage_path($file = '')
	    {
		    if( function_exists('themosis_path') ) {
			    return themosis_path('storage') . ltrim( ( $file ? DS . $file : '' ), DS );
		    } else {
			    return resources_path('storage', $file);
		    }
	    }
	}
	
	if( ! function_exists('config_path') ) {
		/**
	     * Gets the storage path
	     *
	     * @return string
	     */
	    function config_path($file = '')
	    {
		    return resources_path('config', $file);
	    }
	}
	
	if( ! function_exists('view_path') ) {
		/**
	     * Gets the view path
	     *
	     * @return string
	     */
	    function view_path($file = '')
	    {
		    return resources_path('views', $file);
	    }
	}
	
	if (!function_exists('view')) {
	    /**
	     * Helper function to build views.
	     *
	     * @param string $view      The view relative path, name.
	     * @param array  $data      Passed data.
	     * @param array  $mergeData
	     *
	     * @return string
	     */
	    function view($view = null, array $data = [], array $mergeData = [])
	    {
	        $factory = app('view');
	        if (func_num_args() === 0) {
	            return $factory;
	        }
	        return $factory->make($view, $data, $mergeData)->render();
	    }
	}
