<?php

use \App\ACF_Block;

$block = new ACF_Block($args);

$areas = get_field('areas');

// Open the block
echo $block->before_render();

if ($block->is_preview() || $block->is_empty() ) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :
	
	$areas = nl2li( $areas );

	printf( '<div class="location-areas"><ul>%s</ul></div>', $areas );
	
endif;
// close the block
echo $block->after_render();
