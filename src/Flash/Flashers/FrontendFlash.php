<?php 
	
	namespace WPKit\Flash\Flashers;

	class FrontendFlash extends Flash {
	
	    /**
	     * The flash instance.
	     *
	     * @var \WPKit\Flash\Flashers\FrontEndFlash
	     */
	    protected static $instance;
	    
	    /**
	     * The session key.
	     *
	     * @var string
	     */
	    protected $session_key = '__wpkit_frontend_flash';
	    
	    /**
	     * The view file.
	     *
	     * @var string
	     */
	    protected $view = 'flash/frontend';
	    
	    /**
	     * The flash classes.
	     *
	     * @var array
	     */
	    protected $classes = [
		    'success' => 'notice success',
		    'warning' => 'notice warning',
		    'error' => 'notice error'
	    ];
	
	}