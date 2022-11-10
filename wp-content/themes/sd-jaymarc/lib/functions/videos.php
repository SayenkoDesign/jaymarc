<?php
// videos

function _redirect_single_testimonial()
{
    if ( is_singular( 'video' ) ) {
        wp_redirect( sprintf( '%s#%s', trailingslashit( get_post_type_archive_link( 'video' ) ), sanitize_title_with_dashes( get_the_title() ) ), 302 );
        exit();
    }
}
add_action( 'template_redirect', '_redirect_single_testimonial' );

add_filter( 'option_generate_blog_settings', function( $settings ) {
    if ( is_post_type_archive( 'video' ) ) {
        $settings['columns'] = '50';
    }

    return $settings;
} );


add_filter( 'generate_blog_columns',function( $columns ) {
    if ( is_post_type_archive( 'video' ) ) {
        return true;
    }

    return $columns;
}, 15, 1 );



/* add_filter( 'render_block', function( $block_content, $block ){
    if ( ! empty( $block['attrs']['className'] ) && 'testimonial-image' === $block['attrs']['className']  ) {
        
        $video = get_field('video');

        if (!empty($video)) {
            $url = sprintf('<a href="%s?autoplay=1&amp;modestbranding=1&amp;rel=0" class="pulse" data-fancybox=""><span><svg class="video-play-icon" width="76" height="76" role="img" aria-hidden="true" focusable="false" viewBox="0 0 76 76" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="3" transform="translate(3 3)"><circle cx="35" cy="35" r="36.5"></circle><path d="m52 36-24 12v-24z"></path></g></svg></span></a>', $video);
        }

        
        return $url . $block_content;
    }

    return $block_content;
}, 10, 2 );

 */


