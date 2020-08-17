<?php

// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}
if (!class_exists('S9_Sharing_Install')) {

    /**
     * class responsible for setting default settings for social invite.
     */
    class S9_Sharing_Install {

        private static $options = array(
            'connecting_key' => ''
        );

        /**
         * Constructor
         */
        public function __construct() {
            $this->set_default_options();

            add_action('admin_enqueue_scripts', array($this, 'share_add_stylesheet'));
            add_action('wp_footer', array($this, 'enqueue_share_scripts'), 1);
        }

        /**
         * Function for adding default social_profile_data settings at activation.
         */
        public static function set_default_options() {
            global $oss_share_settings;
            if (!get_option('Social9_share_settings')) {
                // Adding Social9 plugin options if not available.
                update_option('Social9_share_settings', self::$options);
            }

            // Get Social9 plugin settings.
            $oss_share_settings = get_option('Social9_share_settings');
        }

        /**
         * Add stylesheet and JavaScript to admin section.
         */
        public function share_add_stylesheet($hook) {
            if ($hook != 'oss_page_social9_share' && $hook != 'toplevel_page_social9_share') {
                return;
            }
            wp_enqueue_style('oss_sharing_style', plugins_url('/assets/css/s9-social-sharing-admin.css', __FILE__));
            wp_enqueue_script('oss_share_admin_javascript', plugins_url('/assets/js/oss_sharing_admin.js', __FILE__), array('jquery', 'jquery-ui-sortable', 'jquery-ui-mouse', 'jquery-touch-punch'), false, true);
        }

        /**
         * Add stylesheet and JavaScript to client sections
         */
        public function enqueue_share_scripts() {
            wp_enqueue_script('oss_javascript_init', plugins_url('/assets/js/oss_sharing.js', __FILE__), array('jquery'), '1.0.0');
            wp_enqueue_script('s9-social-sharing');
        }

        /**
         * Reset Sharing Settings.
         */
        public static function reset_share_options() {
            global $oss_share_settings;
            // Load reset options.
            update_option('Social9_share_settings', self::$options);

            // Get Social9 plugin settings.
            $oss_share_settings = get_option('Social9_share_settings');
        }

    }

    new S9_Sharing_Install();
}
