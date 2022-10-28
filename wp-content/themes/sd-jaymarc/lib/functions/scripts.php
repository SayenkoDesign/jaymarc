<?php
// Scripts


add_action('wp_enqueue_scripts', function () {
	wp_dequeue_style('generate-child');
	wp_enqueue_style('child-style', THEME_STYLES . '/style.css', []);
});


add_action('wp_enqueue_scripts', function () {

	wp_register_script( 'gmaps', 
						sprintf( 'https://maps.googleapis.com/maps/api/js?key=%s', GOOGLE_API_KEY ), 
						false, '', true );
    

    wp_register_script( 'acf-map', get_url( 'scripts/acf-map.js' ), ['gmaps', 'jquery'], '', true ); 

	wp_localize_script( 'acf-map', 
			'map_params', 
			array( 'icon' => sprintf( '%smap-pin.svg', trailingslashit( THEME_IMG ) ),
                   'close' => sprintf( '%sclose.svg', trailingslashit( THEME_IMG ) ),
                   'map_zoom' => 12
            )
	);


	wp_register_script( 'home-map', get_url( 'scripts/home-map.js' ), ['gmaps', 'jquery'], '', true ); 

	wp_register_script( 'contact-map', get_url( 'scripts/contact-map.js' ), ['gmaps', 'jquery'], '', true ); 
	

	//wp_register_script( 'vendor', get_url( 'scripts/vendor.js' ), ['jquery'], '', false );

	wp_register_script(
		'project',
		get_url('scripts/project.js'),
		array(
			'jquery',
			//'vendor',
		),
		null,
		false
	);

	
	// wp_add_inline_script( 'project', file_get_contents( get_path( 'scripts/manifest.js' ) ), 'before' );

	wp_enqueue_script('project');

	if( is_post_type_archive( 'home' ) ) {
        wp_enqueue_script( 'acf-map' );
    }

	if( is_singular( 'home' ) ) {

		$location   = get_field( 'location' );
		$directions = sprintf( 'https://www.google.com/maps/dir/?api=1&destination=%s,%s',                
		$location['lat'], 
		$location['lng']
	  );

		wp_enqueue_script('home-map');
        wp_localize_script( 'home-map', 
			'map_params', 
			array( 'map_zoom' => 12,
				   'lat' => $location['lat'],
				   'lng' => $location['lng'],
				   'directions' => $directions,

            )
	);
    }

/* 	$id = get_the_ID();
    
    if( has_block('acf/contact-map', $id ) ){
        $location   = get_field( 'location' );

		wp_enqueue_script('contact-map');
        wp_localize_script( 'contact-map', 
			'map_params', 
			array( 'map_zoom' => 12,
				   'lat' => $location['lat'],
				   'lng' => $location['lng']

            )
	);
    } */

});