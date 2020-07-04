<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sellbroke
 * @subpackage Sellbroke/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sellbroke
 * @subpackage Sellbroke/admin
 * @author     Your Name <email@example.com>
 */
class Sellbroke_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Sellbroke    The ID of this plugin.
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

	public $api;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sellbroke-api.php';
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->api = new Sellbroke_Api();
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
		 * defined in Sellbroke_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sellbroke_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/css/sellbroke-admin.min.css', array(), $this->version, 'all' );

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
		 * defined in Sellbroke_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sellbroke_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/js/sellbroke-admin.min.js', array( 'jquery' ), $this->version, false );

	}

	public function add_options_page() {
	    add_menu_page(
	        $this->plugin_name,
            "Sellbroke",
            "manage_options",
            'sellbroke',
            array($this, "display_admin_settings_page"),
            '',
            26
        );
    }

    public function display_admin_settings_page() {
	    require_once 'partials/sellbroke-admin-display.php';
    }

    public function authorize() {
        $username = $_POST["username"];
        $password = $_POST["password"];
        echo json_encode($this->api->auth($username, $password));
        die();
    }
}
