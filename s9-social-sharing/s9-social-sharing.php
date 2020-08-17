<?php

// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}

if (!class_exists('S9_Social_Sharing')) {

    /**
     * The main class and initialization point of the plugin.
     */
    class S9_Social_Sharing
    {

        /**
         * Constructor
         */
        public function __construct()
        {

            // Register Activation hook callback.
            $this->install();

            // Declare constants and load dependencies.
            $this->define_constants();
            $this->load_dependencies();

            add_filter('script_loader_tag', array($this, 'social9_front_script'), 10, 3);
            add_action('wp_enqueue_scripts', array($this, 'enqueue_front_scripts'), 5);
            add_action('s9_admin_page', array($this, 'create_oss_menu'), 3);
        }

        function create_oss_menu()
        {

            if (!class_exists('S9_Social_Login')) {
                // Create Menu.		
                add_menu_page('Social9', 'Social Sharing', 'manage_options', 'social9_share', array('S9_Social_Share_Admin', 'options_page'), S9_CORE_URL . 'assets/images/favicon.ico');
            } else {
                // Add Social Sharing menu.
                add_submenu_page('Social9', 'Social Sharing Settings', 'Social Sharing', 'manage_options', 'social9_share', array('S9_Social_Share_Admin', 'options_page'));
            }
        }

        /**
         * Function for setting default options while plgin is activating.
         */
        public static function install()
        {
            global $wpdb;
            require_once(dirname(__FILE__) . '/install.php');
            if (function_exists('is_multisite') && is_multisite()) {
                // check if it is a network activation - if so, run the activation function for each blog id
                $old_blog = $wpdb->blogid;
                // Get all blog ids
                $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
                foreach ($blogids as $blog_id) {
                    switch_to_blog($blog_id);
                    S9_Sharing_Install::set_default_options();
                }
                switch_to_blog($old_blog);
                return;
            } else {
                S9_Sharing_Install::set_default_options();
            }
        }

        /**
         * Define constants needed across the plug-in.
         */
        private function define_constants()
        {
            define('S9_SHARE_PLUGIN_DIR', plugin_dir_path(__FILE__));
            define('S9_SHARE_PLUGIN_URL', plugin_dir_url(__FILE__));
        }

        public static function enqueue_front_scripts()
        {
            wp_enqueue_script("s9-sdk", "//cdn.social9.com/js/socialshare.min.js");
            wp_enqueue_style('s9-social-sharing-front', S9_SHARE_PLUGIN_URL . 'assets/css/s9-social-sharing-front.css', array(), '1.0');
        }
        /**
         * 
         */
        function social9_front_script($tag, $handle, $src)
        {
            global $oss_share_settings;

            $oss_share_settings = get_option('Social9_share_settings');
            if ('s9-sdk' != $handle) {
                return $tag;
            }
            return str_replace(array('<script', "s9-sdk-js"), array('<script async defer content="' . $oss_share_settings['connecting_key'] . '"', "s9-sdk"), $tag);
        }


        /**
         * Loads PHP files that required by the plug-in
         *
         * @global oss_commenting_settings
         */
        private function load_dependencies()
        {
            // Load Social9 files.
            require_once(S9_SHARE_PLUGIN_DIR . 'admin/s9-social-share-admin.php');
            require_once(S9_SHARE_PLUGIN_DIR . 'includes/shortcode/shortcode.php');
        }
    }

    new S9_Social_Sharing();
}
