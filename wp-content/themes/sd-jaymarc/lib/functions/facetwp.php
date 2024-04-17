<?php
// FacetWP
add_filter('facetwp_preload_url_vars', function ($url_vars) {
    if ('about' == FWP()->helper->get_uri()) {
        if (empty($url_vars['department'])) {
            $url_vars['department'] = array('leadership');
        }
    }
    return $url_vars;
});



function fwp_add_facet_labels()
{
?>
    <script>
        (function($) {
            $(document).on('facetwp-loaded', function() {
                $('.facetwp-facet:not(.facetwp-type-pager):not(.facetwp-type-map)').each(function() {
                    var facet_name = $(this).attr('data-name');
                    var facet_label = FWP.settings.labels[facet_name];
                    if ($('.facet-label[data-for="' + facet_name + '"]').length < 1) {
                        $(this).before('<div class="facet-label" data-for="' + facet_name + '">' + facet_label + '</div>');
                    }
                });
            });
        })(jQuery);
    </script>
<?php
}
add_action('wp_head', 'fwp_add_facet_labels', 100);


add_filter('facetwp_facet_render_args', function ($args) {

    $prev_icon = _s_get_icon(
        [
            'icon'    => 'previous',
            'group'    => 'theme',
            'class'    => 'previous',
            'width' => 66,
            'height' => 66,
            'label'    => false,
        ]
    );
    $prev = sprintf('<span class="screen-reader-text" title="%1$s">%1$s</span>%2$s', esc_attr__('Previous', 'generatepress'), $prev_icon);

    $next_icon = _s_get_icon(
        [
            'icon'    => 'next',
            'group'    => 'theme',
            'class'    => 'next',
            'width' => 66,
            'height' => 66,
            'label'    => false,
        ]
    );
    $next = sprintf('<span class="screen-reader-text" title="%1$s">%1$s</span>%2$s', esc_attr__('Next', 'generatepress'), $next_icon);

    $args['facet']['prev_label'] = $prev;
    $args['facet']['next_label'] = $next;


    return $args;
});

add_filter('facetwp_index_row', function ($params, $class) {
    if (in_array($params['facet_name'], ['beds', 'baths'])  && ! empty($params['facet_value']) ) {
        $params['facet_value'] = floor($params['facet_value']);
        $params['facet_display_value'] = sprintf('%d %s', floor($params['facet_display_value']), ucwords($params['facet_name']));
    }
    return $params;
}, 10, 2);



// Set map arguments
add_filter('facetwp_map_init_args', function ($args) {
    $args['init']['mapTypeId'] = 'roadmap'; // roadmap, satellite, hybrid, or terrain
    $args['init']['mapTypeControl'] = false;
    $args['init']['streetViewControl'] = false;
    return $args;
});

// Add custom close icon for infoBox
add_filter('facetwp_map_init_args', function ($settings) {
    $settings['_close'] = sprintf('%sclose.svg', trailingslashit(THEME_IMG));
    return $settings;
}, 10, 1);

// Add infoBox.js
add_filter('facetwp_assets', function ($assets) {

    if (array_key_exists('gmaps', $assets)) { // gmaps
        $assets['infobox.js'] = get_url('scripts/infobox.js');
    }
    
    return $assets;
});

// Remove ifoWindow and add infoBox
add_action('wp_footer', function () { ?>
    <script>
        (function($) {
            if ('object' !== typeof FWP) {
                return;
            }

            $(document).on('facetwp-loaded', function() {
                if ('undefined' === typeof FWP.settings.map || '' === FWP.settings.map) {
                    return;
                }

                if (!FWP.loaded) {

                    var markerOptions = {
                        boxStyle: {
                            width: '260px'
                        },
                        closeBoxMargin: 0,
                        alignBottom: true,
                        closeBoxURL: FWP.settings.map._close
                    }

                    FWP_MAP.InfoBox = new InfoBox(markerOptions);

                    /* google.maps.event.addListener(FWP_MAP.map, 'click', function() {
                        FWP_MAP.InfoBox.close();
                    }); */

                    google.maps.event.addListener(FWP_MAP.InfoBox, 'closeclick', function(event) {
                        $('.location-button').removeClass('active');

                        var markers = FWP_MAP.get_post_markers(FWP_MAP.InfoBox.post_id);
                        console.log(FWP_MAP.InfoBox.post_id);
                        $.each(markers, function(key, marker) {
                            //marker.setIcon("<?php printf('%smarker.svg', trailingslashit(THEME_IMG)) ?>");
                        });

                    });
                }

            });

            $(function() {
                FWP.hooks.addAction('facetwp_map/marker/click', function(marker) {

                });

                FWP.hooks.addAction('facetwp_map/marker/mouseover', function(marker) {

                    google.maps.event.clearListeners(marker, 'spider_click');

                    google.maps.event.addListener(marker, 'spider_click', function() {

                        FWP_MAP.InfoBox.post_id = marker.post_id;

                        if ('' != marker.content) {
                            $('.location-button').removeClass('active');
                            FWP_MAP.InfoBox.close();
                            FWP_MAP.InfoBox.setContent(marker.content);
                            FWP_MAP.InfoBox.setOptions({
                                'pixelOffset': new google.maps.Size(-130, -40)
                            });

                            FWP_MAP.InfoBox.open(FWP_MAP.map, marker);
                            $('.location-button[data-id="' + marker.post_id + '"]').addClass('active');

                            //marker.setIcon("<?php printf('%smarker-active.svg', trailingslashit(THEME_IMG)) ?>");
                        }
                    });
                });
            });

            /**
             * centerMap
             *
             * Centers the map showing all markers in view.
             *
             * @date    22/10/19
             * @since   5.8.6
             *
             * @param   object The map instance.
             * @return  void
             */
            function centerMap(map) {

                // Create map boundaries from all map markers.
                var bounds = new google.maps.LatLngBounds();
                map.markers.forEach(function(marker) {
                    bounds.extend({
                        lat: marker.position.lat(),
                        lng: marker.position.lng()
                    });
                });

                // Case: Single marker.
                if (map.markers.length == 1) {
                    map.setCenter(bounds.getCenter());

                    // Case: Multiple markers.
                } else {
                    map.fitBounds(bounds);
                }
            }


            /**
             * Do JS when clicking location in the sidebar
             *  - https://gist.github.com/djrmom/4760abe263c3819385250351abc8fc42
             * -------------------- */
            $(document).on('click', '.location-button', function(event) {

                /* console.log(e.target);

                if (e.target.querySelector('.post-link')) return; */

                if (event.target.closest('.post-link')) {
                    // Perform your click event handling here
                    console.log('Clicked, ignoring .ignore-click elements');
                    return;
                }

                $('.location-button').removeClass('active');
                $(this).addClass('active');
                var postid = $(this).attr('data-id');
                var markers = FWP_MAP.get_post_markers(postid);

                var map = FWP_MAP.map;

               

                $.each(markers, function(key, marker) {

                    FWP_MAP.InfoBox.post_id = marker.post_id;

                    console.log(marker);

                    if ('' != marker.content) {

                        

                        FWP_MAP.InfoBox.close();
                        FWP_MAP.InfoBox.setContent(marker.content);
                        FWP_MAP.InfoBox.setOptions({
                            'pixelOffset': new google.maps.Size(-130, -40)
                        });
                        FWP_MAP.InfoBox.open(FWP_MAP.map, marker);
                    }

                    var latLng = marker.getPosition();
                    map.setCenter(latLng);

                    //marker.setIcon("<?php printf('%smarker-active.svg', trailingslashit(THEME_IMG)) ?>");


                });

            });

        })(jQuery)
    </script>
<?php }, 100);


// Set Map Pin - we can even set cusotm pins per organization
add_filter('facetwp_map_marker_args', function ($args, $post_id) {

    $marker = get_url('images/marker.svg');

    // get status
    $terms = wp_get_post_terms($post_id, 'home_type');
    if (!empty($terms)) {
        $term = reset($terms);
        $slug = $term->slug;

        $status_marker = get_url(sprintf('images/marker-%s.svg', $slug ));

        error_log($status_marker);

        if(! empty($status_marker)) {
            $marker = $status_marker;
        }
    }

    

    $args['icon'] = array(
        'url' => $marker,
        'scaledSize' => array(
            'width' => 34,
            'height' => 48
        )
    );

    return $args;
}, 10, 2);


// Add Snazzy Maps
add_filter('facetwp_map_init_args', function ($settings) {
    $styles = '[
            {
                "featureType": "administrative",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#e3e3e3"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#cccccc"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit.station.airport",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit.station.airport",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#FFFFFF"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            }
    ]';
    $settings['init']['styles'] = json_decode($styles);
    return $settings;
});

// hide counts from all dropdowns
//add_filter( 'facetwp_facet_dropdown_show_counts', '__return_false' );


/* add_filter( 'facetwp_query_args', function( $query_args, $class ) {
    $facet_name = 'status'; // Replace 'my_facet_name' with the name of your facet
    if ( isset( $class->facets[ $facet_name ] ) ) { // If this facet is present
        error_log('present');
        $selected = $class->facets[ $facet_name ]['selected_values'];
        if ( empty( $selected ) ) { // If this facet has any selected choices
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'home_type',
                'field' => 'slug',
                'terms' => [ 'sold' ],
                'operator' => 'NOT IN',
            )
            );
        }
    }
    return $query_args;
}, 10, 2 ); */



// Filter the marker array (can be used to add custom values)
add_filter('facetwp_map_marker_args', function ($args, $post_id) {

	$post_type = get_post_type( $post_id );

    if('home' !== $post_type ) {
        return $args;
    }

    $title = _s_format_string(get_the_title($post_id), 'h3', ['class' => 'title']);

	$image = sprintf( '%s',
                    get_the_post_thumbnail( $post_id, 'thumbnail' ) 
                ); 

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

    $content = sprintf(
        '<div class="info-box">
                <div class="info-box-top"></div>
                <div class="info-box-middle">%s%s%s</div>
                <div class="info-box-bottom"></div>
                </div>',
        $image,
        $address,
        $learn_more
    );

    $args['content'] = $content;

    return $args;
}, 10, 2);



// Filter the marker array (can be used to add custom values)
add_filter('facetwp_map_marker_args', function ($args, $post_id) {

    $post_type = get_post_type( $post_id );

    if('portfolio' !== $post_type ) {
        return $args;
    }
    
    
    $title  = _s_format_string(get_the_title($post_id), 'h3', ['class' => 'title']);

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