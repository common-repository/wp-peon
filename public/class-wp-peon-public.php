<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Peon
 * @subpackage Wp_Peon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Peon
 * @subpackage Wp_Peon/public
 * @author     Your Name <email@example.com>
 */
class Wp_Peon_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
    
    private $data;
     
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        
        $key = "wp-peon-custom-html";
        $this->data = get_option($key);
        
        //register_shutdown_function(array($this,'error_alert')); 
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-peon-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-peon-public.js', array( 'jquery' ), $this->version, false );

	}
    
    public function insert_in_header() {
        echo trim($this->data['header']);
	}
    
    public function insert_in_footer() {
        echo trim($this->data['footer']);
	}

    public function insert_in_post($content) {
        return ($this->data['before_post'] . $content . $this->data['after_post']);
	}

    function error_alert() 
    { 
        if(is_null($e = error_get_last()) === false) 
        { 
            echo '<p><b>Error: </b>' . $e['message']. ' [' . $e['line'] . ']</p>';
        } 
    }   
    
    public function execute_php($atts, $content, $tag) {
        ob_start();
        $path = dirname(dirname(__FILE__));
           
        $result = @include($path . "/admin/partials/execute-code/" . md5($tag));
        
        $buff = ob_get_contents();
        ob_end_clean();
        if ($result == 1 || $result == false) return $buff;
        return $result;
    }
    
}
