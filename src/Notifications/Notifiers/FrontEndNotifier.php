<?php 
	
	namespace WPKit\Notifications\Notifiers;

	class FrontEndNotifier extends Notifier {
	
	    /**
	     * The notifier instance.
	     *
	     * @var \WPKit\Notifiers\FrontEndNotiifier
	     */
	    protected static $instance;
	    
	    /**
	     * The session key.
	     *
	     * @var string
	     */
	    protected $session_key = '__wpkit_frontend_notifications';
	    
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
	    
	    /**
	     * Runs actions of Notifer
	     *
	     * return void
	     */
	    public function runActions() {
		    
		    add_action( 'frontend_notices', [$this, 'displayNotices'] );
		    add_action( 'wp_footer', [$this, 'clearNotices'] );
		    
	    }
	    
	    /**
	     * Get Notifier Template
	     *
	     * @return string
	     */
	    public function getTemplate( $notice = array() ) 
	    {
		    $template = get_component( 'Notifiers/FrontEnd', 'notice', $notice );
		    return $template ? $template : parent::getTemplate( $notice );
	    }
	
	}