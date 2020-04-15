<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/category-mapping-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	
/**
* Register the administration menu for this plugin into the WordPress Dashboard menu.
*
* @since 1.0.0
*/
 
public function add_plugin_admin_menu() {
	//add_options_page( 'OTIS Category Mapping Settings', 'OTIS Category Mapping', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
	acf_add_options_page(array(
		'page_title' 	=> 'OTIS Category Mapping',
		'menu_title'	=> 'OTIS Category Mapping',
		'menu_slug' 	=> 'otis-category-mapping',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}
 
/**
* Add settings action link to the plugins page.
*
* @since 1.0.0
*/
 
public function add_action_links( $links ) {
	$settings_link = array(
		'<a href="' . admin_url( 'admin.php?page=otis-' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	);
	return array_merge( $settings_link, $links );
}
 
/**
* Render the settings page for this plugin.
*
* @since 1.0.0
*/
 
public function display_plugin_setup_page() {
	include_once( 'partials/category-mapping-admin-display.php' );
}

}

//add ajax for tax selection
add_action( 'wp_ajax_load_city_field_choices', 'load_city_field_choices'  );
function load_city_field_choices() {
	
	$chosen_tax = $_REQUEST['state'];
	
	$terms = get_terms([
		    'taxonomy' => $chosen_tax,
		    'hide_empty' => false,
		]);
	
	$state = [];
	$i = 0;
	
	foreach($terms as $term) {
		
		$state[$i]['value'] = $term->slug;
		$state[$i]['label'] = $term->name;
			
					$i++;
		}
			
		echo json_encode($state);
			
		die();
	}
	
//add ajax for NEW tax selection
add_action( 'wp_ajax_load_new_field_choices', 'load_new_field_choices'  );
function load_new_field_choices() {
	
	$chosen_tax = $_REQUEST['state2'];
	
	$terms = get_terms([
		    'taxonomy' => $chosen_tax,
		    'hide_empty' => false,
		]);
	
	$state = [];
	$i = 0;
	
	foreach($terms as $term) {
		
		$state[$i]['value'] = $term->slug;
		$state[$i]['label'] = $term->name;
			
					$i++;
		}
			
		echo json_encode($state);
			
		die();
	}



