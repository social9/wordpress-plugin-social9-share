<?php
// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * The main class and initialization point of the mailchimp plugin admin.
 */
if ( ! class_exists( 'S9_Social_Share_Admin' ) ) {

    class S9_Social_Share_Admin {

        /**
         * S9_Social_Share_Admin class instance
         *
         * @var string
         */
        private static $instance;

        /**
         * Get singleton object for class S9_Social_Share_Admin
         *
         * @return object S9_Social_Share_Admin
         */
        public static function get_instance() {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof S9_Social_Share_Admin ) ) {
                self::$instance = new S9_Social_Share_Admin();
            }
            return self::$instance;
        }

        /*
         * Constructor for class S9_Social_Share_Admin
         */

        public function __construct() {
            // Registering hooks callback for admin section.
            $this->register_hook_callbacks();
        }

        /*
         * Register admin hook callbacks
         */

        public function register_hook_callbacks() {
            add_action( 'admin_init', array( $this, 'admin_init') );
        }

        /**
         * Callback for admin_menu hook,
         * Register Social9_settings and its sanitization callback. Add Login Radius meta box to pages and posts.
         */
        public function admin_init() {
            register_setting('oss_share_settings', 'Social9_share_settings');
        }

        /*
         * Callback for add_menu_page,
         * This is the first function which is called while plugin admin page is requested
         */
        public static function options_page() {

            include_once S9_SHARE_PLUGIN_DIR."admin/views/settings.php";
            S9_Social_Share_Settings::render_options_page();
        }

    }

    new S9_Social_Share_Admin();
}

