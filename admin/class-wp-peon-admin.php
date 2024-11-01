<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Peon
 * @subpackage Wp_Peon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Peon
 * @subpackage Wp_Peon/admin
 * @author     Owais <soachishti@outlook.com>
 */
class Wp_Peon_Admin {

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

    private $menu_array;
    
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        $this->menu_array = Array (
            'wp-peon' => Array('Info',NULL),
            'wp-peon-custom-html' => Array('Custom HTML', 'menu_custom_html'),
            'wp-peon-execute' => Array('Execute PHP', 'menu_execute'),            
            'wp-peon-explorer' => Array('WP Explorer', 'menu_explorer'),
            'wp-peon-advance' => Array('Advance', 'menu_advance'),
        );   
        
	}

    
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-peon-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-peon-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function add_plugin_admin_menu() {
        
        add_management_page( 
            'Welcome to WP Peon',
            'WP Peon', 
            'manage_options', 
            'wp-peon', 
            array($this,'menu_main')
        );

        /*
        add_menu_page(
            'Welcome to WP Peon',
            'WP Peon', 
            'manage_options', 
            'wp-peon', 
            array($this,'menu_main')
            );
        */
        $menu_array = $this->menu_array;    
        array_shift($menu_array); // Remove first which is main menu to keep away from sub menu.
        
        foreach ($menu_array as $key => $value) 
        {
            add_submenu_page('wp-peon',
                'WP Peon - ' . $value[0],
                $value[0],
                'read',
                $key,
                array($this,$value[1])
            );
        }           
    }
    
    public function menu_main() {
        require ("partials/wp-peon-main.php");
    }
         
    public function menu_advance() {
        require ("partials/wp-peon-advance.php");
    }

    public function menu_custom_html() {
        require ("partials/wp-peon-custom-html.php");
    }
    
    public function menu_explorer() {
        require ("partials/wp-peon-explorer.php");
    }
    
    public function menu_execute() {
        require ("partials/wp-peon-execute.php");
    }
}
