<?php
/*
Plugin Name: 코드엠샵 마이사이트
Plugin URI: 
Description: 웹사이트 소유권인증, 광고 전환 기본 추적 기능을 쉽고 빠르게 이용할 수 있습니다.
Version: 1.1.9
Author: CodeMShop
Author URI: www.codemshop.com
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'MShop_Ownership_Verification' ) ) {

	class MShop_Ownership_Verification {

		protected static $_instance = null;

		protected $slug;
		public $version = '1.1.9';
		public $plugin_url;
		public $plugin_path;
		public function __construct() {
			// Define version constant
			define( 'MSHOP_OWNERSHIP_VERIFICATION_VERSION', $this->version );

			$this->slug = 'mshop-mysite';


			add_action( 'init', array( $this, 'init' ), 0 );
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ), 0 );

			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );
			add_filter( "plugin_action_links", array( $this, 'plugin_action_links' ), 10, 4 );
		}

		public function slug() {
			return $this->slug;
		}

		public function plugin_url() {
			if ( $this->plugin_url ) {
				return $this->plugin_url;
			}

			return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
		}


		public function plugin_path() {
			if ( empty( $this->plugin_path ) ) {
				$this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path;
		}

		function includes() {
			if ( is_admin() ) {
				$this->admin_includes();
			}

			if ( defined( 'DOING_AJAX' ) ) {
				$this->ajax_includes();
			}
			include_once( 'includes/class-msov-verification.php' );
			include_once( 'includes/class-msov-conversation.php' );
		}

		public function ajax_includes() {
			include_once( 'includes/class-msov-ajax.php' );
		}

		public function admin_includes() {
			include_once( 'includes/admin/class-msov-admin.php' );
			include_once( 'includes/admin/class-msov-admin-dashboard.php' );
		}

		public function init() {
			$this->includes();
		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {
			if ( $this->slug == msov_get( $plugin_data, 'slug' ) ) {
				$actions['settings'] = '<a href="' . admin_url( '/admin.php?page=mshop_ownership_verification' ) . '">설정</a>';
				$actions['manual']   = '<a target="_blank" href="https://manual.codemshop.com/docs/my-site/">매뉴얼</a>';
			}

			return $actions;
		}

		public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
			if ( $this->slug == msov_get( $plugin_data, 'slug' ) ) {
				$plugin_meta[] = '<a target="_blank" href="https://manual.codemshop.com/docs/my-site/faq/">FAQ</a>';
				$plugin_meta[] = '<a target="_blank" href="https://wordpress.org/plugins/mshop-mysite/#reviews">별점응원하기</a>';
				$plugin_meta[] = '<a target="_blank" href="https://wordpress.org/plugins/search/codemshop/">함께 사용하면 좋은 플러그인</a>';
			}

			return $plugin_meta;
		}

		public function load_plugin_textdomain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'mshop-mysite' );
			load_textdomain( 'mshop-mysite', WP_LANG_DIR . '/mshop-mysite/mshop-mysite-' . $locale . '.mo' );
			load_plugin_textdomain( 'mshop-mysite', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

	}

	function MSOV() {
		return MShop_Ownership_Verification::instance();
	}

	function msov_get( $array, $key, $default = '' ) {
		return ! empty( $array[ $key ] ) ? $array[ $key ] : $default;
	}

	return MSOV();
}