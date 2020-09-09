<?php

// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}

/**
 * The front function class of Social9 Raas.
 */
if (!class_exists('S9_Social_Share_Inline')) {

    class S9_Social_Share_Inline
    {

        /**
         * Constructor
         * Inline for social sharing.
         */
        public function __construct()
        {
            add_filter('the_content', array($this, 'social_share_top_of_page'));
            add_filter('get_the_excerpt', array($this, 'social_share_top_of_page'));
        }

        function social_share_top_of_page($content)
        {
            global $post, $oss_share_settings;
            $return = '';
            $top = false;
            $bottom = false;
            if (current_filter() == 'the_content') {
                // Show on Post.
                if ( is_single() && $post->post_type == 'post' && ( isset($oss_share_settings['s9-clicker-hr-post']) && $oss_share_settings['s9-clicker-hr-post'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Posts']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Posts']['Bottom']))
                        $bottom = true;
                }

                // Show on Custom Post Types
                if ( is_single() && $post->post_type != 'post' && ( isset($oss_share_settings['s9-clicker-hr-custom']) && $oss_share_settings['s9-clicker-hr-custom'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Custom']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Custom']['Bottom']))
                        $bottom = true;
                }

                // Show on home Page.
                if ( is_front_page() && ( isset($oss_share_settings['s9-clicker-hr-home']) && $oss_share_settings['s9-clicker-hr-home'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Home']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Home']['Bottom']))
                        $bottom = true;
                }

                // Show on Static Page.
                if ( is_page() && (isset($oss_share_settings['s9-clicker-hr-static']) && $oss_share_settings['s9-clicker-hr-static'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Pages']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Pages']['Bottom']))
                        $bottom = true;
                }

                // Show on Posts Page when a static page is the front.
                if ( is_home() && ! is_front_page() && (isset($oss_share_settings['s9-clicker-hr-excerpts']) && $oss_share_settings['s9-clicker-hr-excerpts'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Excerpts']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Excerpts']['Bottom']))
                        $bottom = true;
                }

                // Show on Excerpts Page.
                if ( has_excerpt($post->ID) && (isset($oss_share_settings['s9-clicker-hr-excerpts']) && $oss_share_settings['s9-clicker-hr-excerpts'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Excerpts']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Excerpts']['Bottom']))
                        $bottom = true;
                }
            }

            if ( current_filter() == 'get_the_excerpt' && isset($oss_share_settings['s9-clicker-hr-excerpts']) && $oss_share_settings['s9-clicker-hr-excerpts'] == '1' ) {
                if ( isset($oss_share_settings['horizontal_position']['Excerpts']['Top'])) {
                    $top = true;
                }
                if ( isset($oss_share_settings['horizontal_position']['Excerpts']['Bottom'])) {
                    $bottom = true;
                }
            }

            if ($top) {
                $return = '<div class="s9-widget-wrapper"></div>';
            }

            $return .= $content;

            if ($bottom) {
                $return .= '<div class="s9-widget-wrapper"></div>';
            }
            return $return;
        }
    }

    new S9_Social_Share_Inline();
}
