
<div class="home-photos">
	<?php	
	$photos = get_field('photos');

	if( ! empty( $photos ) ) {
		$first = array_shift( $photos );
	}

	$button = '';

	if( ! empty( $first ) ) {
		$image = wp_get_attachment_image_src( $first, 'large' );
		$button = sprintf('<div class="acf-button-wrapper"><a href="%s" class="acf-button reversed" data-fancybox="gallery">See all %d photos</a></div>', 
		$image[0], count( $photos ) + 1 );
	}

	printf( '%s%s', $button, get_the_post_thumbnail( get_the_ID(), 'large' ) );

	if( ! empty( $photos ) ) {

		echo '<div class="photos">';
		
		foreach( $photos as $photo ) {
			$image = wp_get_attachment_image_src( $photo, 'large' );
			printf( '<a href="%s" data-fancybox="gallery"></a>', $image[0] );
		}

		echo '</div>';
		
	}
	?>
</div>