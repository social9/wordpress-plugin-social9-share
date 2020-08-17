<?php
// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}

if (!class_exists('S9_Core')) {

    /**
     * The main class and initialization point of the plugin.
     */
    class S9_Core {

        /**
         * Constructor
         */
        public function __construct() {
            // Declare constants and register files.
            add_action('s9_reset_admin_action', array($this, 'reset_settings_action'), 10, 2);
            add_action('admin_enqueue_scripts', array($this, 'register_admin_files'));
            add_action('admin_menu', array($this, 'create_oss_menu'));
            add_filter('plugin_action_links', array($this, 'oss_login_setting_links'), 10, 2);
            add_action('s9_reset_admin_ui', array($this, 'reset_settings'));
            $this->define_constants();
        }

        /**
         * Add a settings link to the Plugins page,
         * so people can go straight from the plugin page to the settings page.
         */
        function oss_login_setting_links($links, $file) {
            static $thisPlugin = '';
            if (empty($thisPlugin)) {
                $thisPlugin = S9_ROOT_SETTING_LINK;
            }
            if ($file == $thisPlugin) {
                $settingsLink = '<a href="admin.php?page=';
                if (!class_exists('S9_Social_Login') && !class_exists('S9_Raas_Install')) {
                    $settingsLink .= 'social9_share';
                } else {
                    $settingsLink .= 'Social9';
                }
                $settingsLink .= '">' . __('Settings', 'Social9') . '</a>';

                array_unshift($links, $settingsLink);
            }
            return $links;
        }

        /**
         * Create menu.
         */
        function create_oss_menu() {
            // Create Menu.
            if (class_exists('S9_Social_Login')) {
                add_menu_page('Social9', 'Social9', 'manage_options', 'Social9', array('S9_Activation_Admin', 'options_page'), S9_CORE_URL . 'assets/images/favicon.ico');
                add_submenu_page('Social9', 'Activation Settings', 'Activation', 'manage_options', 'Social9', array('S9_Activation_Admin', 'options_page'));
            }
            // Customize Menu based on do_action order
            do_action('s9_admin_page');
        }

        /**
         * Define constants needed across the plug-in.
         */
        public function define_constants() {
            define('S9_PLUGIN_VERSION', '3.6');
            define('S9_CORE_DIR', plugin_dir_path(__FILE__));
            define('S9_CORE_URL', plugin_dir_url(__FILE__));
        }

        /**
         * Registers Scripts and Styles needed throughout front end of plugin
         *
         */
        public function register_admin_files() {
            wp_register_style('s9-admin-style', S9_CORE_URL . 'assets/css/s9-admin-style.css', array(), S9_PLUGIN_VERSION);
            wp_enqueue_style('s9-admin-style');
        }

        /**
         * 
         * @param type $option_name
         */
        public function reset_settings($option_name) {
            if(current_user_can('manage_options')){
            ?>
            <div class="s9_options_container">	
                <div class="s9-row s9-reset-body">
                    <h5><?php _e('Reset all the ' . $option_name . ' options to the default recommended settings.', 'Social9'); ?>
                        <span class="s9-tooltip" data-title="<?php _e('This option will reset all the settings to the default ' . $option_name . ' plugin settings', 'Social9'); ?>">
                            <span class="dashicons dashicons-editor-help"></span>
                        </span>
                    </h5>
                    <div>
                        <form method="post" action="" class="s9-reset">
                            <?php submit_button('Reset All Options', 'secondary', 'reset', false); ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            }
        }

        /**
         * 
         * @param type $option
         * @param type $settings
         */
        public static function reset_settings_action($option, $settings) {
            if(current_user_can('manage_options')){
                update_option($option, $settings);
            }
        }

    }

    new S9_Core();
}
