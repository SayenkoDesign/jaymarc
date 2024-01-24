<?php
// Portfolio 

// Filter the marker array (can be used to add custom values)
add_filter('facetwp_map_marker_args', function ($args, $post_id) {

    $title      = _s_format_string(get_the_title($post_id), 'h3', ['class' => 'title']);

    $address = get_home_address($post_id);

    $area = _s_get_primary_term('area', $post_id );
    if( ! empty( $area ) ) {
        $area = sprintf( '<h4>%s</h4>', $area->name );
    }

    $learn_more = sprintf(
        '<div class="acf-button-wrapper"><a class="acf-button blue reversed" href="%s">%s</a></div>',
        get_permalink($post_id),
        __('View Details')
    );


    $directions = '';
    if (!empty($location['lat'])) {
        $directions = sprintf(
            '<span class="directions"><a href="https://www.google.com/maps/dir/?api=1&destination=%s,%s" target="_blank">%s [+]</a></span>',
            $location['lat'],
            $location['lng'],
            __('Get Directions')
        );
    }


    $content = sprintf(
        '<div class="info-box">
                <div class="info-box-top"></div>
                <div class="info-box-middle">%s%s%s</div>
                <div class="info-box-bottom"></div>
                </div>',
        $title,
        $area,
        $learn_more
    );

    $args['content'] = $content;

    return $args;
}, 10, 2);