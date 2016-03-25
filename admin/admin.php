<?php
/**
 * Admin function.
 *
 * @package Cherry Team
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// If class 'Cherry_Composer_Admin' not exists.
if ( ! class_exists( 'Cherry_Composer_Admin' ) ) {

	/**
	 * Sets up and initializes the admin Cherry Composer plugin.
	 *
	 * @since 1.0.0
	 */
	class Cherry_Composer_Admin{
		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Core instance
		 *
		 * @var null
		 */
		public $core = null;

		/**
		 * UI builder instance
		 *
		 * @var object
		 */
		public $ui_builder;

		/**
		 * Construct cherry composer plugin to initialize.
		 *
		 * @since 1.0.0
		 */
		function __construct( $core ) {
			$this->core = $core;
			add_action('admin_menu', array( $this, 'register_plugin_page' ) );
		}

		/**
		 * Register plugin submenu page.
		 *
		 * @since 1.0.0
		 */
		public function register_plugin_page(){
			add_submenu_page( 'options-general.php', __( 'Cherry Composer', 'cherry-composer' ), __( 'Cherry Composer', 'cherry-composer' ), 'manage_options', 'cherry_composer', array( $this, 'admin_page' )  );
		}

		/**
		 * Cherry composer plugin page in admin panel.
		 *
		 * @since 1.0.0
		 */
		public function admin_page() {
			$this->ui_builder = $this->core->init_module( 'cherry-ui-elements' );

			require_once( CHERRY_COMPOSER_DIR . 'admin/admin-page.php' );
		}

		public function render_ui_elements( $filds ) {
			$html = '';
			$class_name = '';
			$new_ui_class = null;
			$ui_args = null;

			foreach ( $filds as $key => $value ) {
				$class_name = 'UI_' . ucfirst( $value['type'] );
				$ui_args = $value;
				$ui_args['id'] = $ui_args['name'] = $key;

				$new_ui_class = new $class_name ( $ui_args );

				$html .= $new_ui_class->render();
			}

			return $html;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $core = null ) {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $core );
			}
			return self::$instance;
		}
	}
	$core = cherry_composer()->get_core();
	Cherry_Composer_Admin::get_instance( $core );
}
