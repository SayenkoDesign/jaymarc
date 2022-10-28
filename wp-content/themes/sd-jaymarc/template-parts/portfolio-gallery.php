
<div class="photos">
	<?php	
	$photos = get_field('photos');

	$additional_photos = '';
	
	printf( '<div><a href="%s" data-fancybox="gallery">%s</a></div>', 
			get_the_post_thumbnail_url( get_the_ID(),  'large' ), 
			get_the_post_thumbnail( get_the_ID(),  'large' ) 
	);
	
	if( ! empty( $photos ) ) {
		
		foreach( $photos as $key => $photo ) {
			$image = wp_get_attachment_image( $photo, 'large' );
			$image_src = wp_get_attachment_image_src( $photo, 'large' );
			if( $key < 2 ) {
				printf( '<div><a href="%s" data-fancybox="gallery">%s</a></div>', $image_src[0], $image );
			} else {
				$additional_photos .= sprintf( '<a href="%s" data-fancybox="gallery"></a>', $image_src[0] );
			}
			
		}
		
	} 

	
?>
</div>
<?php

echo $additional_photos;

	/* $button = '';

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
		
	} */
	?>
