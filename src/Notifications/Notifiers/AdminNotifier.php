<?php 
	
	namespace WPKit\Notifications\Notifiers;

	class AdminNotifier extends Notifier {
	
	    /**
	     * The notifier instance.
	     *
	     * @var \WPKit\Notifications\Notifiers\FrontEndNotiifier
	     */
	    protected static $instance;
	    
	    /**
	     * The session key.
	     *
	     * @var string
	     */
	    protected $session_key = '__wpkit_admin_notifications';
	    
	    /**
	     * The view file.
	     *
	     * @var string
	     */
	    protected $view_file = 'notifiers/admin';
	    
	    /**
	     * Runs actions of Notifer
	     *
	     * return void
	     */
	    protected function actions() {
		    
		    add_action( 'admin_notices', [$this, 'print'] );
		    
	    }
	
	}