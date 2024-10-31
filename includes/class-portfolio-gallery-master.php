<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://icanwp.com
 * @since      1.0.0
 *
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Portfolio_Gallery_Master
 * @subpackage Portfolio_Gallery_Master/includes
 * @author     iCanWP Team, Sean Roh, Chris Couweleers
 */
class Portfolio_Gallery_Master {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Portfolio_Gallery_Master_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $portfolio_gallery_master    The string used to uniquely identify this plugin.
	 */
	protected $portfolio_gallery_master;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->portfolio_gallery_master = 'portfolio-gallery-master';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Portfolio_Gallery_Master_Loader. Orchestrates the hooks of the plugin.
	 * - Portfolio_Gallery_Master_i18n. Defines internationalization functionality.
	 * - Portfolio_Gallery_Master_Admin. Defines all hooks for the admin area.
	 * - Portfolio_Gallery_Master_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-portfolio-gallery-master-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-portfolio-gallery-master-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-portfolio-gallery-master-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-portfolio-gallery-master-public.php';

		$this->loader = new Portfolio_Gallery_Master_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Portfolio_Gallery_Master_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Portfolio_Gallery_Master_i18n();
		$plugin_i18n->set_domain( $this->get_portfolio_gallery_master() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Portfolio_Gallery_Master_Admin( $this->get_portfolio_gallery_master(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'pgm_add_admin_menu' );
		$this->loader->add_action( 'init', $plugin_admin, 'pgm_register_custom_post_type' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'pgm_init_options' );
		$this->loader->add_action( 'wp_login', $plugin_admin, 'pgm_user_logins' );
		$this->loader->add_action( 'wp_ajax_pgm_portfolio_dismiss_pro_notice', $plugin_admin, 'pgm_portfolio_dismiss_pro_notice' );
		if( version_compare( PHP_VERSION, '5.6.0', '<' ) ){
			$this->loader->add_action( 'admin_notices', $plugin_admin, 'pgm_notice_php_version_critical' );
		}
		if( empty( get_option( 'pgm_notice_get_pro_version_dismissed' ) ) ){
			$this->loader->add_action( 'admin_notices', $plugin_admin, 'pgm_notice_get_pro_version' );
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Portfolio_Gallery_Master_Public( $this->get_portfolio_gallery_master(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'pgm_register_shortcode' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_portfolio_gallery_master() {
		return $this->portfolio_gallery_master;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Portfolio_Gallery_Master_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
