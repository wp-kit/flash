<?php 
	
	namespace WPKit\Notifications\Notifiers;

	class FrontEndNotifier extends Notifier {
	
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
	    protected $session_key = '__wpkit_frontend_notifications';
	    
	    /**
	     * The view file.
	     *
	     * @var string
	     */
	    protected $view = 'notifiers/frontend';
	    
	    /**
	     * The notifier classes.
	     *
	     * @var array
	     */
	    protected $classes = [
		    'success' => 'notice success',
		    'warning' => 'notice warning',
		    'error' => 'notice error'
	    ];
	
	}