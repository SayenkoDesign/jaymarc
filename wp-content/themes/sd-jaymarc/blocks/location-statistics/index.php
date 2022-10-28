<?php

use \App\ACF_Block;

$block = new ACF_Block($args);




// Open the block
echo $block->before_render();

if ( is_admin() && ( $block->is_preview() || $block->is_empty() ) ) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :

	$rows = get_field('statistics');
	
	if( ! empty( $rows ) ) {

		echo '<h4>Statistics</h4>';

		echo '<ul>';

		foreach( $rows as $row ) {
			printf( '<li class="location__link">%s</li>', $row['title'] );
		}

		echo '</ul>';
		
	}


endif;
// close the block
echo $block->after_render();
