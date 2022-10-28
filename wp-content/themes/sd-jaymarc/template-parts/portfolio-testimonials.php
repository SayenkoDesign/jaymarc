<?php
$display = get_field( 'testimonials_display' );
$display = strtolower( $display );

if( 'slider' == $display ) {
	get_template_part( 'template-parts/testimonials', 'slider' );
} else {
	get_template_part( 'template-parts/testimonials', 'grid' );
}