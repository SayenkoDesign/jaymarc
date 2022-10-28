<?php
// Portfolio 

add_filter( 'option_generate_blog_settings', function( $settings ) {
    if ( is_post_type_archive( 'plan' ) ) {
        $settings['columns'] = '33';
    }

    return $settings;
} );


add_filter( 'generate_blog_columns',function( $columns ) {
    if ( is_post_type_archive( 'plan' ) ) {
        return true;
    }

    return $columns;
}, 15, 1 );