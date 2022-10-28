<?php
use \App\ACF_Block;

$block = new ACF_Block( $args );

// Open the block
echo $block->before_render();

if( $block->is_preview() ) :
	get_template_part( sprintf('blocks/%s/%s', $block->get_name(), 'placeholder' ), NULL, [ 'block' => $block ]  );
else :	
	
	get_template_part( sprintf('blocks/%s/components/%s', $block->get_name(), 'grid' ) );
	
endif;

// close the block
echo $block->after_render();