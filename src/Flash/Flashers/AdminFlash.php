<?php 
	
	namespace WPKit\Flash\Flashers;

	class AdminFlash extends Flash {
	
	    /**
	     * The flash instance.
	     *
	     * @var \WPKit\Flash\Flashers\AdminFlash
	     */
	    protected static $instance;
	    
	    /**
	     * The session key.
	     *
	     * @var string
	     */
	    protected $session_key = '__wpkit_admin_flash';
	    
	    /**
	     * The view file.
	     *
	     * @var string
	     */
	    protected $view = 'flash/admin';
	    
	    /**
	     * Runs actions of Flash
	     *
	     * return void
	     */
	    protected function actions() {
		    
		    add_action( 'admin_notices', [$this, 'print'] );
		    
	    }
	
	}