<?php 
	
	namespace WPKit\Notifications\Notifiers;
	
	use Illuminate\Support\Collection;

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
	        
	        return $this;
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
	        return $this->add($message, 'success', $flash);
	    }
	
	    /**
	     * Adds a warning notice.
	     *
	     * @param string  $message
	     * @param boolean $flash
	     */
	    public function warning($message, $flash = false)
	    {
	        return $this->add($message, 'warning', $flash);
	    }
	
	    /**
	     * Adds an error notice.
	     *
	     * @param string  $message
	     * @param boolean $flash
	     */
	    public function error($message, $flash = false)
	    {
	        return $this->add($message, 'error', $flash);
	    }
	    
	    /**
	     * Gets all the accumulated notices.
	     *
	     * @return array
	     */
	    public function all()
	    {
	        return $this->collection()->all();
	    }
	    
	    /**
	     * Gets all the accumulated notices as a collection object
	     *
	     * @return array
	     */
	    public function collection() {
		    return new Collection(session()->get($this->session_key, []));
	    }
	
	    /**
	     * Prints all the accumulated notices.
	     *
	     * @return void
	     */
	    public function print( $item = array() )
	    {
		    echo $this->render( $item );
	    }
	    
	    /**
	     * Renders all the accumulated notices.
	     *
	     * @return void
	     */
	    public function render( $item = array() ) {
		    $keys = array_keys( $item );
		    $items = $item ? ( is_numeric( reset( $keys ) ) ? $item : [$item] ) : $this->all();
		    $output = implode( array_map( [ $this, 'build' ], $items ) );
		    $this->clear();
		    return $output;
	    }
	    
	    /**
	     * Get Notifier Template
	     *
	     * @return string
	     */
	    public function build( $notice = array() ) 
	    {
		    if( view()->exists( $this->view ) ) {
		    	return view( $this->view, $notice );
		    } else {
		    	return sprintf( '<div class="%s"><p>%s</p></div>', $notice['class'], $notice['message'] );
		    }
	    }
	    
	    /**
	     * Clears all the accumulated notices.
	     *
	     * @return void
	     */
	    public function clear()
	    {
	    	return session()->put($this->session_key, []);
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