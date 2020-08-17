<?php

//if uninstall not called from WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

if ( ! is_multisite() ) {
    delete_oss_options();
} else {
    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $original_blog_id = get_current_blog_id();
    foreach ( $blog_ids as $blog_id ) {
        switch_to_blog( $blog_id );
        delete_oss_options();
    }
    switch_to_blog( $original_blog_id );
}

function delete_oss_options() {
    delete_option( 'Social9_settings' );
    delete_option( 'Social9_share_settings' );
    delete_option( 'S9_Plugin_Version' );
}
