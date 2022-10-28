<?php

// Hide ACF fields from non sayenko emails
function _s_hide_acf_menu_item() {
    $current_user = wp_get_current_user();

    if( is_admin() && strpos( $current_user->user_email, 'sayenkodesign') === false ) {
        // remove menu items
        add_filter('acf/settings/show_admin', '__return_false');
    }
}

add_action('init', '_s_hide_acf_menu_item');



function _s_hide_admin_menu_items() {
    $current_user = wp_get_current_user();

    if( strpos( $current_user->user_email, 'sayenkodesign') === false ) {
        // remove menu items
        remove_menu_page( 'plugins.php' );
        //remove_menu_page( 'tools.php' ); 
    }
}
add_action( 'admin_menu', '_s_hide_admin_menu_items', 999 );