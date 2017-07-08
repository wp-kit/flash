<?php 
	
	namespace WPKit\Notifications\Notifiers;

	class Notifier {
	
	    /**
	     * The notifier instance.
	     *
	     * @var \WPKit\Notifications\Notifiers\Notifier
	     */
	    protected static $instance;
	    
	    /**
	     * The session key.
	     *
	     * @var string
	     */
	    protected $session_key = '__wpkit_notifications';
	    
	    /**
	     * The view file.
	     *
	     * @var string
	     */
	    protected $view_file = 'notifiers/notification';
	    
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
	        $this->actions();
	    }
	
	    /**
	     * Adds a notice.
	     *
	     * @param string  $message
	     * @param string  $class
	     */
	    public function add($message, $type = 'success')
	    {
	        $notification = [
	            'message' => $message,
	            'class'   => $this->className( $type )
	        ];;
	
	        session()->push($this->session_key, $notification);
	        
	        return $notification;
	    }
	    
	    /**
	     * Runs actions of Notifer
	     *
	     * return void
	     */
	    protected function actions() {}
	    
	    /**
	     * Get type class
	     *
	     * return string
	     */
	    protected function className( $type ) {
		    
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
	        $this->add($message, 'success', $flash);
	    }
	
	    /**
	     * Adds a warning notice.
	     *
	     * @param string  $message
	     * @param boolean $flash
	     */
	    public function warning($message, $flash = false)
	    {
	        $this->add($message, 'warning', $flash);
	    }
	
	    /**
	     * Adds an error notice.
	     *
	     * @param string  $message
	     * @param boolean $flash
	     */
	    public function error($message, $flash = false)
	    {
	        $this->add($message, 'error', $flash);
	    }
	    
	    /**
	     * Gets all the accumulated notices.
	     *
	     * @return array
	     */
	    public function all()
	    {
	        return session()->get($this->session_key, []);
	    }
	
	    /**
	     * Prints all the accumulated notices.
	     *
	     * @return void
	     */
	    public function print()
	    {
		    var_dump($this->all());
	        foreach ($this->all() as $notice)
	        {
	            $this->render( $notice, true );
	        }
	
			$this->clear();
	    }
	    
	    /**
	     * Renders a single notice.
	     *
	     * @return void
	     */
	    public function render( $notice = array(), $echo = false )
	    {
	        $html = $this->template( $notice );
	        
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
	    public function template( $notice = array() ) 
	    {
		    return view( $this->view_file, $notice );
	    }
	    
	    /**
	     * Clears all the accumulated notices.
	     *
	     * @return void
	     */
	    public function clear()
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