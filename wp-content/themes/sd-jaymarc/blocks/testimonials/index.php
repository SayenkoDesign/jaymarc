<?php
use \App\ACF_Block;

$block = new ACF_Block( $args );

$posts = get_field( 'posts' );
$display = get_field( 'display' );
$display = strtolower( $display );

// Open the block
echo $block->before_render();

if( empty( $posts ) ) :
	get_template_part( sprintf('blocks/%s/%s', $block->get_name(), 'placeholder' ), NULL, [ 'block' => $block ]  );
else :	
	
	if( 'slider' == $display ) {
		get_template_part( sprintf('blocks/%s/components/%s', $block->get_name(), 'slider' ) );
	} else {
		get_template_part( sprintf('blocks/%s/components/%s', $block->get_name(), 'grid' ) );
	}
	
endif;

// close the block
echo $block->after_render();