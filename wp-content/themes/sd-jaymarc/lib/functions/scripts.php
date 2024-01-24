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

		wp_register_script( 'contact-map', get_url( 'scripts/contact-map.js' ), ['gmaps', 'jquery'], '', true ); 
		

		wp_register_script( 'home-map', get_url( 'scripts/home-map.js' ), ['gmaps', 'jquery'], '', true ); 

	
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

	if(is_singular('home')) {
		$location   = get_field( 'location' );
		$directions = sprintf( 'https://www.google.com/maps/dir/?api=1&destination=%s,%s',                
			$location['lat'], 
			$location['lng']
		);

		wp_localize_script( 'home-map', 
			'map_params', 
			[ 'map_zoom' => 12,
				   'lat' => $location['lat'],
				   'lng' => $location['lng'],
				   'directions' => $directions

            ]);

		wp_enqueue_script('home-map');
	}
	
});