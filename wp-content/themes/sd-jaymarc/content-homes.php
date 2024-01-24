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

$location   = get_field( 'location' );

$status = '';
$estimated_completion = get_field('estimated_completion');


$title = _s_format_string( get_the_title(), 'span', ['class' => 'title' ] ); 


$price = sprintf( '$%s', number_format( get_field('price') ) );
$hide_price_message = get_field('hide_price_message');
if( ! empty( $hide_price_message ) ) {
    $price = $hide_price_message;
}


$home_type = _s_get_primary_term('home_type');

$arrow = _s_get_icon(
    [
        'icon'	=> 'arrow',
        'group'	=> 'theme',
        'width' => 28,
        'height' => 14,
        'label'	=> false,
    ]
);

$class = 'arrow';

/* if( 'available' != $home_type->slug ) {
    $arrow = '';
    $class = '';
} */

$permalink = get_permalink();

$estimated_completion = get_field( 'estimated_completion' );

$tour_this_home = ! empty( $estimated_completion ) ? 'Est. Completion ' . $estimated_completion : 'Tour this Home';

$post_link = sprintf( '<a class="post-link" href="%s"><strong>%s</strong><span class="%s">%s%s</span></a>', $permalink, $home_type->name, $class, $tour_this_home, $arrow );
    
$learn_more = sprintf( '<div class="acf-button-wrapper"><a class="acf-button acf-button-large blue reversed" href="%s">%s</a></div>', $permalink, __( 'view details' ) );


$directions = sprintf( '<span class="directions"><a href="https://www.google.com/maps/dir/?api=1&destination=%s,%s" target="_blank">%s [+]</a></span>',                $location['lat'], 
                       $location['lng'] ,
                       __( 'Get Directions' )
                     );


$size = wp_is_mobile() ? 'medium' : 'large';
$image = sprintf( '<a href="%s" class="thumbnail-link" data-fancybox="gallery-%s">%s</a>', 
                    get_the_post_thumbnail_url( get_the_ID(), 'large' ), 
                    get_the_ID(), 
                    get_the_post_thumbnail( get_the_ID(), $size ) 
                ); 

$images = '';
$photos = get_field('photos');

if( ! empty( $photos ) ) {
    
    foreach( $photos as $photo ) {
        $photo = wp_get_attachment_image_src( $photo, 'large' );
        $images .= sprintf( '<a href="%s" data-fancybox="gallery-%d"></a>', $photo[0], get_the_ID() );
    }

    $images = sprintf( '<div class="photos">%s</div>', $images );    
}




$classes = [ 'cell marker' ]; 





$left = _s_get_icon(
    [
        'icon'	=> 'arrow-left',
        'group'	=> 'theme',
        'class'	=> 'arrow-left',
        'width' => 14,
        'height' => 26,
        'label'	=> false,
    ]
);

$right = _s_get_icon(
    [
        'icon'	=> 'arrow-right',
        'group'	=> 'theme',
        'class'	=> 'arrow-right',
        'width' => 14,
        'height' => 26,
        'label'	=> false,
    ]
);

$arrows = sprintf( '<div class="arrows">%s%s</div>', $left, $right );

/*
gallery
completion date field

city - taxonomy
state - taxonomy
zip - number
description
Type: taxonomy
bed number
bath number
sqft number
plan posttype
*/

$classes = ['location-button'];

printf( '<article class="%s" data-id="%d">      
            <div class="thumbnail">%s%s%s</div>
            <div class="panel">
            <!--<div class="count"><span>%s</span></div>-->
            <div class="details" data="location-details">
                <h3 data-mh="location-title">%s</h3>
                %s
				<p>%s, %s %s</p>
                %s
                %s
            </div>
            <div class="show-for-mobile">%s</div>
            </div>
         </article>', 
        join( ' ', get_post_class( $classes ) ),
        get_the_ID(), 
        $arrows,
        $image, 
        $images,
        $wp_query->current_post + 1,
        $price, 
        $title,
		_s_get_primary_term('area')->name,
		$location['state_short'],
		$location['post_code'],
        $post_link,
        get_home_data(),
        $learn_more
);