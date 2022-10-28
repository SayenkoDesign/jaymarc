<?php
$location   = get_field( 'location' );

wp_enqueue_script('contact-map');
wp_localize_script( 'contact-map', 
	'map_params', 
	array( 'map_zoom' => 16,
		   'lat' => $location['lat'],
		   'lng' => $location['lng']

	)
);

$image = get_field('image');
$address_1 = get_field('address_line_1');
$address_2 = get_field('address_line_2');
$directions = get_field('directions');

$address = '';

if( ! empty( $address_1 ) ) {
	$address .= sprintf( '<h4>%s</h4>', $address_1 );
}

if( ! empty( $address_2 ) ) {
	$address .= sprintf( '<p>%s</p>', $address_2 );
}

$link = '';

if( ! empty( $directions ) ) {
	$link = sprintf( '<div class="acf-button-wrapper"><a href="%s" class="acf-button acf-button-more-arrow" target="_blank">Directions</a></div>', $directions );
}

use \App\ACF_Block;

$block = new ACF_Block($args);

// Open the block
echo $block->before_render();

if ($block->is_preview() || $block->is_empty()) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :
?>

	<?php
	if( ! empty( $address ) ) {
		printf( '<div class="map-info-box"><div class="map-info-box__wrapper"><div class="map-info-box__content">%s%s</div></div></div>', $address, $link );
	}
	?>	

	<div class="map-canvas-wrap"><div id="map-canvas"></div></div>
<?php

endif;

// close the block
echo $block->after_render();
