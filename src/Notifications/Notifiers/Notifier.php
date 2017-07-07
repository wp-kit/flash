<?php 
	
	namespace WPKit\Notifications\Notifiers;

	class Notifier {
	
	    /**
	     * The notifier instance.
	     *
	     * @var \WPKit\Core\Notifier
	     */
	    protected static $instance;
	    
	    /**
	     * The session key.
	     *
	     * @var string
	     */
	    protected $session_key = '__wpkit_notifications';
	    
	    /**
	     * The notifier classes.
	     *
	     * @var array
	     */
	    protected $classes = [
		    'success' => 'notice notice-success',
		    'warning' => 'notice notice-warning',
		    'error' => 'notice notice-error'
	    ];
	
	    /**
	     * Constructs the Notifier.
	     */
	    public function __construct()
	    {
	        if ( ! self::$instance)
	        {
	            self::$instance = $this;
	        }
	        if(!session_id()) {
		        session_start();
	        }
	        $this->runActions();
	    }
	
	    /**
	     * Adds a notice.
	     *
	     * @param string  $message
	     * @param string  $class
	     * @param boolean $flash
	     */
	    public function addNotice($message, $type = 'success')
	    {
	        $notification = [
	            'message' => $message,
	            'class'   => $this->getTypeClass( $type )
	        ];
	
	        $notices = $this->getNotices();
	        $notices[] = $notification;
	        session()->put($this->session_key, $notices);
	        
	        return $notification;
	    }
	    
	    /**
	     * Runs actions of Notifer
	     *
	     * return void
	     */
	    protected function runActions() {
		    
		    add_action('shutdown', [$this, 'clearNotices']);
		    
	    }
	    
	    /**
	     * Get type class
	     *
	     * return string
	     */
	    protected function getTypeClass( $type ) {
		    
		    $type = ! empty( $this->classes[$type] ) ? $type : 'warning';
		    
		    return $this->classes[$type];
		    
	    }
	
	    /**
	     * Adds a success notice.
	     *
	     * @param string  $message
	     * @param boolean $flash
	     */
	    public function success($message, $flash = false)
	    {
	        $this->addNotice($message, 'success', $flash);
	    }
	
	    /**
	     * Adds a warning notice.
	     *
	     * @param string  $message
	     * @param boolean $flash
	     */
	    public function warning($message, $flash = false)
	    {
	        $this->addNotice($message, 'warning', $flash);
	    }
	
	    /**
	     * Adds an error notice.
	     *
	     * @param string  $message
	     * @param boolean $flash
	     */
	    public function error($message, $flash = false)
	    {
	        $this->addNotice($message, 'error', $flash);
	    }
	    
	    /**
	     * Gets all the accumulated notices.
	     *
	     * @return array
	     */
	    public function getNotices()
	    {
	        return session()->get($this->session_key, []);
	    }
	
	    /**
	     * Displays all the accumulated notices.
	     *
	     * @return void
	     */
	    public function displayNotices()
	    {
	        foreach ($this->getNotices() as $notice)
	        {
	            $this->renderNotice( $notice, true );
	        }
	
			$this->clearNotices();
	    }
	    
	    /**
	     * Renders a single notice.
	     *
	     * @return void
	     */
	    public function renderNotice( $notice = array(), $echo = false )
	    {
	        $html = $this->getTemplate( $notice );
	        
	        if( $echo ) {
		        
		        echo $html;
		        
		        return;
		        
	        }
	        
	        return $html;
	        
	    }
	    
	    /**
	     * Get Notifier Template
	     *
	     * @return string
	     */
	    public function getTemplate( $notice = array() ) 
	    {
		    return "<div class=\"{$notice['class']}\"><p>{$notice['message']}</p></div>";
	    }
	    
	    /**
	     * Clears all the accumulated notices.
	     *
	     * @return void
	     */
	    public function clearNotices()
	    {
	    	session()->put($this->session_key, []);
	    }
	
	    /**
	     * Allow static calls — akin to a facade.
	     *
	     * @param  string $name
	     * @param  array  $arguments
	     * @return mixed
	     */
	    public static function __callStatic($name, $arguments)
	    {
	        if ( ! self::$instance)
	        {
	            new self;
	        }
	
	        return call_user_func_array([self::$instance, $name], $arguments);
	    }
	
	}