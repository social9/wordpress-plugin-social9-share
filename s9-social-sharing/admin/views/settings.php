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

    class S9_Social_Share_Settings
    {
        private static function vertical_share_interface_position($page, $settings)
        {
            /*
            echo '<div class="s9-show-options">';
            $interface_location = array('Top Left', 'Top Right', 'Bottom Left', 'Bottom Right');
            foreach ($interface_location as $location) {
?>
                <label>
                    <input type="checkbox" class="s9-clicker-vr-<?php echo strtolower($page); ?>-options default" name="Social9_share_settings[vertical_position][<?php echo $page; ?>][<?php echo $location; ?>]" value="<?php echo $location; ?>" <?php echo (isset($settings['vertical_position'][$page][$location]) && $settings['vertical_position'][$page][$location] == $location) ? 'checked' : ''; ?> />
                    <span class="s9-text"><?php _e(str_replace(' ', '-', $location) . ' of the content', 'Social9'); ?></span>
                </label>
            <?php
            }
            echo '</div>';
            */
        }

        private static function horizontal_share_interface_position($page, $settings)
        {
            echo '<div class="s9-show-options">';
            $interface_location = array('Top', 'Bottom');
            foreach ($interface_location as $location) {?>
                <label>
                    <input type="checkbox" class="s9-clicker-hr-<?php echo strtolower($page); ?>-options default" name="Social9_share_settings[horizontal_position][<?php echo $page; ?>][<?php echo $location; ?>]" value="<?php echo $location; ?>" <?php echo (isset($settings['horizontal_position'][$page][$location]) && $settings['horizontal_position'][$page][$location] == $location) ? 'checked' : ''; ?> />
                    <span class="s9-text"><?php _e($location . ' of the content', 'Social9'); ?></span>
                </label>
            <?php
            }
            echo '</div>';
        }

        private static function activation_settings($settings)
        {
            ?>
            <!-- Advanced Settings -->
            <div id="s9_options_tab-1" class="s9-tab-frame s9-active">
                <div class="s9_options_container">
                    <div class="s9-row">
                        <input type="hidden" id="opensocialshare_share_settings_interface_script" name="Social9_share_settings[interface_script]" value="<?php echo ($settings['interface_script'] != '') ? $settings['interface_script'] : ''; ?>" />
                        <iframe src="https://social9.com/configurations?view=cms" scrolling="no" frameborder="0" style="border:none;overflow:hidden;width:100%;height: 500px;" allowtransparency="true"></iframe>
                        <script>
                            window.addEventListener("message", function(event) {
                                if (event.data && event.data.code != "") {
                                    console.log(event.data);
                                    document.getElementById('opensocialshare_share_settings_interface_script').value = encodeURIComponent(event.data.code);
                                    var b = jQuery('#oSSAdvanceSetting').serialize();
                                    jQuery.post('options.php', b).error(
                                        function() {
                                            console.log('error');
                                        }).success(function() {
                                        console.log('success');
                                    });
                                }
                            }, false);
                        </script>

                    </div><!-- s9-row -->
                </div>
            </div>
        <?php
        }

        private static function inline_settings($settings)
        {
        ?>
            <!-- Advanced Settings -->
            <div id="s9_options_tab-2" class="s9-tab-frame">
                <div class="s9_options_container">
                    <div class="s9-row cf">
                        <h3><?php _e('Choose the location(s) to display the widget', 'OpenSocialShare'); ?>
                            <span class="s9-tooltip" data-title="Sharing widget will be displayed at the selected location(s)">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div>
                            <input type="checkbox" class="s9-toggle" id="s9-clicker-hr-home" name="Social9_share_settings[s9-clicker-hr-home]" value="1" <?php echo (isset($settings['s9-clicker-hr-home']) && $settings['s9-clicker-hr-home'] == '1') ? 'checked' : ''; ?> />
                            <label class="s9-show-toggle" for="s9-clicker-hr-home">
                                <?php _e('Home Page', 'OpenSocialShare'); ?>
                                <span class="s9-tooltip" data-title="<?php _e('Home page of your blog', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Home', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="s9-toggle" id="s9-clicker-hr-post" name="Social9_share_settings[s9-clicker-hr-post]" value="1" <?php echo (isset($settings['s9-clicker-hr-post']) && $settings['s9-clicker-hr-post'] == '1') ? 'checked' : ''; ?> />
                            <label class="s9-show-toggle" for="s9-clicker-hr-post">
                                <?php _e('Blog Post', 'OpenSocialShare'); ?>
                                <span class="s9-tooltip" data-title="<?php _e('Each post of your blog', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Posts', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="s9-toggle" id="s9-clicker-hr-static" name="Social9_share_settings[s9-clicker-hr-static]" value="1" <?php echo (isset($settings['s9-clicker-hr-static']) && $settings['s9-clicker-hr-static'] == '1') ? 'checked' : ''; ?> />
                            <label class="s9-show-toggle" for="s9-clicker-hr-static">
                                <?php _e('Static Pages', 'OpenSocialShare'); ?>
                                <span class="s9-tooltip" data-title="<?php _e('Static pages of your blog (e.g &ndash; about, contact, etc.)', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Pages', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="s9-toggle" id="s9-clicker-hr-excerpts" name="Social9_share_settings[s9-clicker-hr-excerpts]" value="1" <?php echo (isset($settings['s9-clicker-hr-excerpts']) && $settings['s9-clicker-hr-excerpts'] == '1') ? 'checked' : ''; ?> />
                            <label class="s9-show-toggle" for="s9-clicker-hr-excerpts">
                                <?php _e('Post Excerpts', 'OpenSocialShare'); ?>
                                <span class="s9-tooltip" data-title="<?php _e('Post excerpts page', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Excerpts', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="s9-toggle" id="s9-clicker-hr-custom" name="Social9_share_settings[s9-clicker-hr-custom]" value="1" <?php echo (isset($settings['s9-clicker-hr-custom']) && $settings['s9-clicker-hr-custom'] == '1') ? 'checked' : ''; ?> />
                            <label class="s9-show-toggle" for="s9-clicker-hr-custom">
                                <?php _e('Custom Post Types', 'OpenSocialShare'); ?>
                                <span class="s9-tooltip" data-title="<?php _e('Custom Post Types', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Custom', $settings); ?>
                        </div>
                    </div>

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
            </div><?php
                }
                private static function floating_settings($settings)
                {
                    ?>
            <!-- Advanced Settings -->
            <div id="s9_options_tab-3" class="s9-tab-frame">
                <div class="s9_options_container">
                    <div class="s9-row cf">
                        <h3>
                            <?php _e('Choose the location(s) to display the widget', 'OpenSocialShare') ?>
                            <span class="s9-tooltip" data-title="<?php _e('Sharing widget will be displayed at the selected location(s)', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div>
                            <input type="checkbox" class="s9-toggle" id="s9-clicker-vr-home" name="Social9_share_settings[s9-clicker-vr-home]" value="1" <?php echo (isset($settings['s9-clicker-vr-home']) && $settings['s9-clicker-vr-home'] == '1') ? 'checked' : ''; ?> />
                            <label class="s9-show-toggle" for="s9-clicker-vr-home">
                                <?php _e('Home Page', 'OpenSocialShare'); ?>
                                <span class="s9-tooltip" data-title="<?php _e('Home page of your blog', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::vertical_share_interface_position('Home', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="s9-toggle" id="s9-clicker-vr-post" name="Social9_share_settings[s9-clicker-vr-post]" value="1" <?php echo (isset($settings['s9-clicker-vr-post']) && $settings['s9-clicker-vr-post'] == '1') ? 'checked' : ''; ?> />
                            <label class="s9-show-toggle" for="s9-clicker-vr-post">
                                <?php _e('Blog Posts', 'OpenSocialShare'); ?>
                                <span class="s9-tooltip" data-title="<?php _e('Each post of your blog', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::vertical_share_interface_position('Post', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="s9-toggle" id="s9-clicker-vr-static" name="Social9_share_settings[s9-clicker-vr-static]" value="1" <?php echo (isset($settings['s9-clicker-vr-static']) && $settings['s9-clicker-vr-static'] == '1') ? 'checked' : ''; ?> />
                            <label class="s9-show-toggle" for="s9-clicker-vr-static">
                                <?php _e('Static Pages', 'OpenSocialShare'); ?>
                                <span class="s9-tooltip" data-title="<?php _e('Static pages of your blog (e.g &ndash; about, contact, etc.)', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::vertical_share_interface_position('Static', $settings); ?>
                        </div><!-- unnamed div -->
                        <div>
                            <input type="checkbox" class="s9-toggle" id="s9-clicker-vr-custom" name="Social9_share_settings[s9-clicker-vr-custom]" value="1" <?php echo (isset($settings['s9-clicker-vr-custom']) && $settings['s9-clicker-vr-custom'] == '1') ? 'checked' : ''; ?> />
                            <label class="s9-show-toggle" for="s9-clicker-vr-custom">
                                <?php _e('Custom Post Types', 'OpenSocialShare'); ?>
                                <span class="s9-tooltip" data-title="<?php _e('Custom Post Types', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::vertical_share_interface_position('Custom', $settings); ?>
                        </div><!-- unnamed div -->
                    </div>
                </div>
            </div>
        <?php
                }
                private static function help_settings($settings)
                {
                    ?>
            <!-- Advanced Settings -->
            <div id="s9_options_tab-4" class="s9-tab-frame">
                <div class="s9_options_container">
                    <div class="s9-row cf">
                        <!-- Settings -->
                        <div class="s9-frame">
                            <a href="https://docs.social9.com/install/wordpress/" target="_blank"><?php _e('Plugin Installation, Configuration and Troubleshooting', 'Social9') ?></a>
                            <a href="https://social9.com/urlshortener" target="_blank"><?php _e('URL Shortener', 'Social9') ?></a>
                            <a href="https://social9.com/comments/dashboard" target="_blank"><?php _e('Comments', 'Social9') ?></a>
                        </div><!-- s9-frame -->
                    </div>
                </div>
            </div>
        <?php
                }
                /**
                 * Render social sharing settings page.
                 */
                public static function render_options_page()
                {
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
                <ul class="s9-options-tab-btns">
                    <li class="nav-tab s9-active" data-tab="s9_options_tab-1"><?php _e('Activation', 'OpenSocialShare') ?></li>
                    <li class="nav-tab" data-tab="s9_options_tab-2"><?php _e('Inline Widgets', 'OpenSocialShare') ?></li>
                    <li class="nav-tab" data-tab="s9_options_tab-3"><?php _e('Floating Widgets', 'OpenSocialShare') ?></li>
                    <li class="nav-tab" data-tab="s9_options_tab-4"><?php _e('Help', 'OpenSocialShare') ?></li>
                    
                </ul>
                <div style="clear:both;"></div>
                <div id="s9_options_tabs" class="cf">
                    <!-- Settings -->
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('oss_share_settings');
                        settings_errors();
                        self::activation_settings($oss_share_settings);
                        self::inline_settings($oss_share_settings);
                        self::floating_settings($oss_share_settings);
                        self::help_settings($oss_share_settings);
                        submit_button('Save changes');
                        ?>
                    </form>
                    <?php do_action('s9_reset_admin_ui', 'Social Sharing'); ?>
                </div>
            </div><!-- End LR-wrap -->

<?php
                }
            }

            new S9_Social_Share_Settings();
        }
