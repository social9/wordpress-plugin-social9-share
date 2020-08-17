<?php

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * The front function class of Social9 Raas.
 */
if ( ! class_exists( 'S9_Social_Share_Shortcode' ) ) {

    class S9_Social_Share_Shortcode {

        /**
         * Constructor
         * Shortcode for social sharing.
         */
        public function __construct() {
            add_shortcode('Social9_Share', array($this, 'sharing_shortcode'));
        }

        /**
         * This function will be used to insert content where shortcode is used.
         * Shortcode [Social9_Share]
         * 
         * @global type $post
         * @global type $oss_share_settings
         * @param type $params
         * @return type
         */
        public static function sharing_shortcode($params) {
            return '<div class="s9-widget-wrapper"></div>';
        }

    }

    new S9_Social_Share_Shortcode();
}
