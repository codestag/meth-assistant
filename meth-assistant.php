<?php
/**
 * Plugin Name: Meth Assistant
 * Plugin URI: https://github.com/Codestag/meth-assistant
 * Description: A plugin to assist Meth theme in adding widgets.
 * Author: Codestag
 * Author URI: https://codestag.com
 * Version: 1.0
 * Text Domain: meth-assistant
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Meth
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Meth_Assistant' ) ) :
	/**
	 *
	 * @since 1.0
	 */
	class Meth_Assistant {

		/**
		 *
		 * @since 1.0
		 */
		private static $instance;

		/**
		 *
		 * @since 1.0
		 */
		public static function register() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Meth_Assistant ) ) {
				self::$instance = new Meth_Assistant();
				self::$instance->init();
				self::$instance->define_constants();
				self::$instance->includes();
			}
		}

		/**
		 *
		 * @since 1.0
		 */
		public function init() {
			add_action( 'enqueue_assets', 'plugin_assets' );
		}

		/**
		 *
		 * @since 1.0
		 */
		public function define_constants() {
			$this->define( 'MA_VERSION', '1.0' );
			$this->define( 'MA_DEBUG', true );
			$this->define( 'MA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'MA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 *
		 * @param string $name
		 * @param string $value
		 * @since 1.0
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 *
		 * @since 1.0
		 */
		public function includes() {
			require_once MA_PLUGIN_PATH . 'includes/widgets/intro.php';
			require_once MA_PLUGIN_PATH . 'includes/widgets/features.php';
			require_once MA_PLUGIN_PATH . 'includes/widgets/feature-box.php';
			require_once MA_PLUGIN_PATH . 'includes/widgets/static-content.php';
			require_once MA_PLUGIN_PATH . 'includes/widgets/portfolio.php';
			require_once MA_PLUGIN_PATH . 'includes/widgets/team.php';
			require_once MA_PLUGIN_PATH . 'includes/widgets/blog.php';
			require_once MA_PLUGIN_PATH . 'includes/widgets/contact.php';
			require_once MA_PLUGIN_PATH . 'includes/widgets/testimonials.php';

		}
	}
endif;


/**
 *
 * @since 1.0
 */
function meth_assistant() {
	return Meth_Assistant::register();
}

/**
 *
 * @since 1.0
 */
function meth_assistant_activation_notice() {
	echo '<div class="error"><p>';
	echo esc_html__( 'Meth Assistant requires Meth WordPress Theme to be installed and activated.', 'meth-assistant' );
	echo '</p></div>';
}

/**
 *
 *
 * @since 1.0
 */
function meth_assistant_activation_check() {
	$theme = wp_get_theme(); // gets the current theme
	if ( 'Meth' == $theme->name || 'Meth' == $theme->parent_theme ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			add_action( 'after_setup_theme', 'meth_assistant' );
		} else {
			meth_assistant();
		}
	} else {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'meth_assistant_activation_notice' );
	}
}

// Plugin loads.
meth_assistant_activation_check();
