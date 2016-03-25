<?php
/**
 * Plugin Name: Cherry Composer
 * Plugin URI:  http://www.cherryframework.com/
 * Description: Plugin for WordPress.
 * Version:     1.0.0
 * Author:      Cherry Team
 * Author URI:  http://www.cherryframework.com/
 * Text Domain: cherry-composer
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 *
 * @package  Cherry Team
 * @category Core
 * @author   Cherry Team
 * @license  GPL-3.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// If class 'Cherry_Composer' not exists.
if ( ! class_exists( 'Cherry_Composer' ) ) {

	/**
	 * Sets up and initializes the Cherry Composer plugin.
	 *
	 * @since 1.0.0
	 */
	class Cherry_Composer {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * A reference to an instance of cherry framework core class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private $core = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Set the constants needed by the theme.
			add_action( 'plugins_loaded', array( $this, 'constants' ), 0 );

			// Load the core functions/classes required by the rest of the theme.
			add_action( 'plugins_loaded', array( $this, 'get_core' ), 1 );

			// Language functions and translations setup.
			add_action( 'plugins_loaded', array( $this, 'l10n' ), 2 );

			// Load the theme includes.
			add_action( 'plugins_loaded', array( $this, 'includes' ), 3 );

			// Initialization of modules.
			add_action( 'plugins_loaded', array( $this, 'init' ), 4 );

			// Load admin files.
			add_action( 'wp_loaded', array( $this, 'admin' ), 1 );

			// Enqueue admin assets.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

			// Register public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 9 );

			// Enqueue public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 10 );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, array( __CLASS__, 'activation' ) );
			register_deactivation_hook( __FILE__, array( __CLASS__, 'deactivation' ) );
		}

		/**
		 * Defines constants for the plugin.
		 *
		 * @since 1.0.0
		 */
		function constants() {

			/**
			 * Set the version number of the plugin.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_COMPOSER_VERSION', '1.0.0' );

			/**
			 * Set the slug of the plugin.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_COMPOSER_SLUG', basename( dirname( __FILE__ ) ) );

			/**
			 * Set constant path to the plugin directory.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_COMPOSER_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

			/**
			 * Set constant path to the plugin URI.
			 *
			 * @since 1.0.0
			 */
			define( 'CHERRY_COMPOSER_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

			/**
			 * Sets the path to the core framework directory.
			 *
			 * @since 1.0.0
			 */
			defined( "CHERRY_DIR" ) or define( 'CHERRY_DIR', trailingslashit( CHERRY_COMPOSER_DIR ) . 'cherry-framework' );

			/**
			 * Sets the path to the core framework directory URI.
			 *
			 * @since 1.0.0
			 */
			defined( "CHERRY_URI" ) or define( 'CHERRY_URI', trailingslashit( CHERRY_COMPOSER_URI ) . 'cherry-framework' );
		}

		/**
		 * Loads the core functions. These files are needed before loading anything else in the
		 * plugin because they have required functions for use.
		 *
		 * @since  1.0.0
		 */
		public function get_core() {
				/**
				 * Fires before loads the core plugin functions.
				 *
				 * @since 1.0.0
				 */
				do_action( '__tm_core_before' );

				if ( null !== $this->core ) {
					return $this->core;
				}

				if ( ! class_exists( 'Cherry_Core' ) ) {
					require_once( trailingslashit( CHERRY_DIR ) . 'cherry-core.php' );
				}

				$this->core = new Cherry_Core( array(
					'base_dir' => CHERRY_DIR,
					'base_url' => CHERRY_URI,
					'modules'  => array(
						'cherry-js-core' => array(
							'priority' => 999,
							'autoload' => true,
						),
						'cherry-ui-elements' => array(
							'priority' => 999,
							'autoload' => false,
						),
						'cherry-dynamic-css' => array(
							'priority' => 999,
							'autoload' => false,
						),
						'cherry-google-fonts-loader' => array(
							'priority' => 999,
							'autoload' => false,
						),
					),
				) );

				return $this->core;
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 */
		function l10n() {
			load_plugin_textdomain( 'cherry-composer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Loads files from the 'public/includes' folder.
		 *
		 * @since 1.0.0
		 */
		function includes() {
			//require_once( CHERRY_COMPOSER_DIR . 'public/includes/class-cherry-composer-registration.php' );
		}

		/**
		 * Run initialization of modules.
		 *
		 * @since 1.0.0
		 */
		function init() {
			//require_once( CHERRY_COMPOSER_DIR . 'public/includes/class-cherry-composer-registration.php' );
		}

		/**
		 * Loads admin files.
		 *
		 * @since 1.0.0
		 */
		function admin() {
			if ( is_admin() ) {
				require_once( CHERRY_COMPOSER_DIR . 'admin/admin.php' );
			}
		}

		/**
		 * Enqueue admin assets.
		 *
		 * @since 1.0.0
		 *
		 */
		function enqueue_admin_assets( ) {

		}

		/**
		 * Register public-facing assets.
		 *
		 * @since 1.0.0
		 */
		public function register_assets() {

			/*wp_enqueue_style(
				'cherry-composer',
				plugins_url( 'public/assets/css/style.css', __FILE__ ), array(), CHERRY_COMPOSER_VERSION
			);*/

		}

		/**
		 * Enqueue assets.
		 *
		 * @since 1.0.0
		 *
		 */
		function enqueue_assets( ) {

		}

		/**
		 * On plugin activation.
		 *
		 * @since 1.0.0
		 */
		public static function activation() {

		}

		/**
		 * On plugin deactivation.
		 *
		 * @since 1.0.0
		 */
		public static function deactivation() {

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

	/**
	 * Returns instanse of main plugin configuration class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function cherry_composer() {
		return Cherry_Composer::get_instance();
	}

	cherry_composer();
}