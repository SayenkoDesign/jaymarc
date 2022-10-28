<?php
$photo = get_field('secondary-photo');
if( empty( $photo ) ) {
	return false;
}
?>
<div class="secondary-photo">
	<?php	
	echo wp_get_attachment_image( $photo, 'large' );
	?>
</div>