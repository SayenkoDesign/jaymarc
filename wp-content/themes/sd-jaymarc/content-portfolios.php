<?php
/**
 * The template for displaying single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_query;

$active = ! $wp_query->current_post ? 'true' : 'false';

$title = _s_format_string( get_the_title(), 'span', ['class' => 'title' ] ); 

$permalink = get_permalink();
    
$learn_more = sprintf( '<div class="acf-button-wrapper"><a class="acf-button blue reversed" href="%s">%s</a></div>', $permalink, __( 'Learn more' ) );

$size = wp_is_mobile() ? 'medium' : 'large';
$image = get_the_post_thumbnail( get_the_ID(), $size );

$area = _s_get_primary_term('area');
if( ! empty( $area ) ) {
    $area = sprintf( '<h4>%s</h4>', $area->name );
}

$classes = ['location-button'];



printf( '<article class="%s" data-id="%d">
                 
            <div class="thumbnail">%s</div>
            <div class="panel">
            <!--<div class="count"><span>%s</span></div>-->
            <div class="details" data="location-details">
                <h3 data-mh="location-title">%s</h3>
                %s
            </div>
            <div class="show-for-mobile">%s</div>
            </div>
         </article>', 
        join( ' ', get_post_class( $classes ) ),
        get_the_ID(), 
        $image, 
        $wp_query->current_post + 1,
        $title,
        $area,
        $learn_more
);