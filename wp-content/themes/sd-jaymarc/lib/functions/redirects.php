<?php
// Redirects

add_action( 'template_redirect', function() {
	if ( is_singular( 'review' ) ) {
		wp_redirect( get_post_type_archive_link( 'review' ), 301 );
		exit;
	  }
} );