<?php 
	
	namespace WPKit\Notifications\Notifiers;

	class AdminNotifier extends Notifier {
	
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
	    protected $session_key = '__wpkit_admin_notifications';
	    
	    /**
	     * Runs actions of Notifer
	     *
	     * return void
	     */
	    protected function runActions() {
		    
		    add_action( 'admin_notices', [$this, 'displayNotices'] );
		    add_action( 'admin_footer', [$this, 'clearNotices'] );
		    
	    }
	    
	    /**
	     * Get Notifier Template
	     *
	     * @return string
	     */
	    public function getTemplate( $notice = array() ) 
	    {
		    $template = get_element( 'Notifiers/Admin', 'notice', $notice );
		    return $template ? $template : parent::getTemplate( $notice );
	    }
	
	}