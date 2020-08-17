<?php
// S9_Social_Sharing_Settings
// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}

/**
 * The main class and initialization point of the plugin settings page.
 */
if (!class_exists('S9_Social_Share_Settings')) {

    class S9_Social_Share_Settings {

        private static function vertical_share_interface_position($page, $settings) {
            echo '<div class="s9-show-options">';
            $interface_location = array('Top Left', 'Top Right', 'Bottom Left', 'Bottom Right');
            foreach ($interface_location as $location) {
                ?>
                <label>
                    <input type="checkbox" class="s9-clicker-vr-<?php echo strtolower($page); ?>-options default" name="Social9_share_settings[vertical_position][<?php echo $page; ?>][<?php echo $location; ?>]" value="<?php echo $location; ?>" <?php echo ( isset($settings['vertical_position'][$page][$location]) && $settings['vertical_position'][$page][$location] == $location ) ? 'checked' : ''; ?> />
                    <span class="s9-text"><?php _e(str_replace(' ', '-', $location) . ' of the content', 'Social9'); ?></span>
                </label>
                <?php
            }
            echo '</div>';
        }

        private static function horizontal_share_interface_position($page, $settings) {
            echo '<div class="s9-show-options">';
            $interface_location = array('Top', 'Bottom');
            foreach ($interface_location as $location) {
                ?>
                <label>
                    <input type="checkbox" class="s9-clicker-hr-<?php echo strtolower($page); ?>-options default" name="Social9_share_settings[horizontal_position][<?php echo $page; ?>][<?php echo $location; ?>]" value="<?php echo $location; ?>" <?php echo ( isset($settings['horizontal_position'][$page][$location]) && $settings['horizontal_position'][$page][$location] == $location ) ? 'checked' : ''; ?> />
                    <span class="s9-text"><?php _e($location . ' of the content', 'Social9'); ?></span>
                </label>
                <?php
            }
            echo '</div>';
        }

        private static function advance_settings($settings) {
            ?>
            <!-- Advanced Settings -->
            <div id="s9_options_tab-1" class="s9-tab-frame s9-active">
                <div class="s9_options_container">
                <div class="s9-row">
                        <h3><?php _e('Your User ID', 'Social9'); ?>
                            <span class="s9-tooltip tip-bottom" data-title="<?php _e('User ID is a unique key to your account that helps us to identify that it\'s you! in ? section of user ID', 'Social9'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div>
                            <input type="text" name="Social9_share_settings[connecting_key]" class="s9-connecting" value="<?php echo isset($settings['connecting_key'])?$settings['connecting_key']:'';?>"></input>
                        </div>
                        <span><?php _e('Get User ID from <a href="https://social9.com/tools/installation#wordpress" target="_blank" >Here</a>', 'Social9'); ?><br><?php _e('Read more about the installation doc form <a href="https://docs.social9.com/" target="_blank" >Here</a>', 'Social9'); ?></span>
                    </div><!-- s9-row -->
                    <br/>
                    <div class="s9-row">
                        <h3><?php _e('Short Code for Inline Sharing widget', 'Social9'); ?>
                            <span class="s9-tooltip tip-bottom" data-title="<?php _e('Copy and paste the following shortcode into a page or post to display a Inline sharing widget', 'Social9'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div>
                            <textarea rows="1" onclick="this.select()" spellcheck="false" class="s9-shortcode" readonly="readonly">[Social9_Share]</textarea>
                        </div>
                        <span><?php _e('Additional shortcode examples can be found <a href="http://www.social9.com/docs/wordpress-social-share#!shortcode" target="_blank" >Here</a>', 'Social9'); ?></span>
                    </div><!-- s9-row -->
                </div>
            </div>
            <?php
        }

        /**
         * Render social sharing settings page.
         */
        public static function render_options_page() {
            global $oss_share_settings;

            $oss_share_settings = get_option('Social9_share_settings');

            if (isset($_POST['reset']) && current_user_can('manage_options')) {
                S9_Sharing_Install::reset_share_options();
                echo '<p style="display:none;" class="s9-alert-box s9-notif">Sharing settings have been reset and default values have been applied to the plug-in</p>';
                echo '<script type="text/javascript">jQuery(function(){jQuery(".s9-notif").slideDown().delay(3000).slideUp();});</script>';
            }
            ?>
            <!-- LR-wrap -->
            <div class="wrap s9-wrap cf">
                <header>
                    <h2 class="logo"><a href="//www.social9.com" target="_blank">social9</a><em>Simplified Social Share</em></h2>
                </header>
                <div id="s9_options_tabs" class="cf">
                    <!-- Settings -->
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('oss_share_settings');
                        settings_errors();
                        self::advance_settings($oss_share_settings);
                        submit_button('Save changes');
                        ?>
                    </form>
                    <?php do_action('s9_reset_admin_ui', 'Social Sharing'); ?>
                </div>
                <!-- Settings -->
                <div class="s9-sidebar">
                    <div class="s9-frame">
                        <h4><?php _e('Help', 'Social9'); ?></h4>
                        <div>
                            <a href="https://docs.social9.com/install/wordpress/" target="_blank"><?php _e('Plugin Installation, Configuration and Troubleshooting', 'Social9') ?></a>
                            <a href="https://social9.com/urlshortener" target="_blank"><?php _e('URL Shortener', 'Social9') ?></a>
                            <a href="https://social9.com/comments/dashboard" target="_blank"><?php _e('Comments', 'Social9') ?></a>
                        </div>
                    </div><!-- s9-frame -->

                </div>
            </div><!-- End LR-wrap -->

            <?php
        }

    }

    new S9_Social_Share_Settings();
}