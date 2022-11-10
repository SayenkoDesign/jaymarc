<?php
// Homes

add_filter( 'get_the_archive_title' , function( $title ) {
    return str_replace( 'Archives:', '', $title );
} );

/**
 * Define default terms for custom taxonomies in WordPress 3.0.1
 *
 * @author    Michael Fields     http://wordpress.mfields.org/
 * @props     John P. Bloch      http://www.johnpbloch.com/
 *
 * @since     2010-09-13
 * @alter     2010-09-14
 *
 * @license   GPLv2
 */
function mfields_set_default_object_terms( $post_id, $post ) {
    if ( 'publish' === $post->post_status ) {
        $defaults = array(
            'area' => array( 'bellevue' ),
            'home_type' => array( 'available' ),
            );
        $taxonomies = get_object_taxonomies( $post->post_type );
        foreach ( (array) $taxonomies as $taxonomy ) {
            $terms = wp_get_post_terms( $post_id, $taxonomy );
            if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
                wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
            }
        }
    }
}
add_action( 'save_post', 'mfields_set_default_object_terms', 100, 2 );


function get_homes_address( $post_id ) {
    
    $location = get_field('location', $post_id );
    
    if( $location ) {

        // Loop over segments and construct HTML.
        $address = '';
        foreach( array('street_number', 'street_name', 'city', 'state_short', 'post_code' ) as $i => $k ) {
            if( isset( $location[ $k ] ) ) {
                $seperator = 'city' == $k ? ',' : '';
                $br = 'city' == $k ? '<br />' : '';
                $address .= sprintf( '%s<span class="segment-%s">%s</span>%s ', $br, $k, $location[ $k ], $seperator );
            }
        }

        // Trim trailing comma.
        $address = trim( $address, ', ' );

        // Display HTML.
        return sprintf( '<div class="address">%s</div>', $address );
    }
}

function get_home_address( $post_id ) {
    
    $location = get_field('location', $post_id );
    
    if( $location ) {

        // Loop over segments and construct HTML.
        $address = '';
        foreach( array('street_number', 'street_name', 'city', 'state_short', 'post_code' ) as $i => $k ) {
            if( isset( $location[ $k ] ) ) {
                $seperator = 'city' == $k ? ',' : '';
                $break = 'street_name' == $k ? '<span class="break"></span>' : '';
                $address .= sprintf( '<span class="segment-%s">%s%s</span>%s ', $k, $location[ $k ], $seperator, $break );
            }
        }

        // Trim trailing comma.
        $address = trim( $address, ', ' );

        // Display HTML.
        return sprintf( '<div class="address">%s</div>', $address );
    }
}


function get_home_data() {
    $sqft = sprintf( '%s', number_format( get_field('square_feet') ) );
    $beds = get_field('beds');
    $baths = get_field('baths');
    $floor_plan = get_field( 'floor_plan' );

    ob_start();
    ?>

    <ul class="specs">
        <li class="beds"><span><?php echo $beds;?></span> Beds</li>
        <li class="sqft"><span><?php echo $sqft;?></span> Sq. Ft.</li>
        <li class="baths"><span><?php echo $baths;?></span> Baths</li>
        <?php if( ! empty( $floor_plan ) ):?>
        <li class="plan"><span>Plan:</span> <?php echo get_the_title( $floor_plan );?></li>
        <?php endif;?>
    </ul>
    <?php
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

function featured_home_days( $post_id ) {

    ob_start();

    if( have_rows('days', $post_id ) ):

        echo ' <ul class="days">';

        while( have_rows('days', $post_id ) ) : the_row();
    
            $day = get_sub_field('day');
            $time = get_sub_field('time');

            printf( '<li><strong>%s</strong><span>%s</span></li>', $day, $time );
    
        endwhile;

        echo '</ul>';
    
    endif;
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}