
<div class="photos">
	<?php	
	$photos = get_field('photos');

	$additional_photos = '';

	if( ! empty( $photos ) ) {

		printf('<div><div class="acf-button-wrapper"><a href="%s" class="acf-button reversed" data-fancybox="gallery">See all %d photos</a></div>%s</div>', 
			get_the_post_thumbnail_url( get_the_ID(),  'large' ), 
			count( $photos ) + 1,
			get_the_post_thumbnail( get_the_ID(),  'large' ) 
		);
		
	} else {
		printf( '<div><a href="%s" data-fancybox="gallery">%s</a></div>', 
			get_the_post_thumbnail_url( get_the_ID(),  'large' ), 
			get_the_post_thumbnail( get_the_ID(),  'large' ) 
		);
	}
	
	

	
	if( ! empty( $photos ) ) {
		
		foreach( $photos as $key => $photo ) {
			$image_src = wp_get_attachment_image_src( $photo, 'large' );
			$additional_photos .= sprintf( '<a href="%s" data-fancybox="gallery"></a>', $image_src[0] );
			
		}
		
	} 

	get_template_part( 'template-parts/home', 'map' );

	get_template_part( 'template-parts/home', 'video' );
?>
</div>
<?php
echo $additional_photos;