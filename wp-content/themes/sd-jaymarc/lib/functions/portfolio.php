<?php
// Portfolio 

add_filter( 'option_generate_blog_settings', function( $settings ) {
    if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_filters' ) ) {
        $settings['columns'] = '33';
    }

    return $settings;
} );


add_filter( 'generate_blog_columns',function( $columns ) {
    if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_filters' ) ) {
        return true;
    }

    return $columns;
}, 15, 1 );


add_filter( 'generate_blog_masonry',function( $masonry ) {
    if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_filters' ) ) {
        return true;
    }

    return $masonry;
}, 15, 1 );


/* add_filter('post_class', 'set_row_post_class', 10,3);
function set_row_post_class($classes, $class, $post_id){
    if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_filters' ) ) {

		$aspect_ratio = strtolower( get_field('aspect_ratio') );

		if( 'wide' == $aspect_ratio ) {
			$classes = str_replace('grid-33', 'grid-66', $classes );
		}

		if( 'tall' == $aspect_ratio ) {
			$classes[] = 'grid-tall';
		}

		
	}
 
    return $classes;
} */