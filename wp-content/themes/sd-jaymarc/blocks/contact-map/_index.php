<?php

$image = get_field('image');
$address_1 = get_field('address_line_1');
$address_2 = get_field('address_line_2');
$directions = get_field('directions');

$address = '';

if( ! empty( $address_1 ) ) {
	$address .= sprintf( '<p>%s</p>', $address_1 );
}

if( ! empty( $address_2 ) ) {
	$address .= sprintf( '<p>%s</p>', $address_2 );
}

$link = '';

if( ! empty( $directions ) ) {
	$link = sprintf( '<div class="acf-button-wrapper"><a href="%s">Directions</a></div>', $directions );
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
	$icon = _s_get_icon(
		[
			'icon'	=> 'marker',
			'group'	=> 'theme',
			'class'	=> 'marker',
			'width' => 34,
			'height' => 48,
			'label'	=> false,
		]
	);

	if( ! empty( $address ) ) {
		printf( '<div class="map-info-box"><div class="map-info-box__wrapper">%s%s%s</div></div>', $address, $link, $icon );
	}
	?>	

	<div class="image">

		<?php
		echo wp_get_attachment_image($image, 'large');
		?>
	</div>
<?php

endif;

// close the block
echo $block->after_render();
