<?php

use \App\ACF_Block;

$block = new ACF_Block($args);




// Open the block
echo $block->before_render();

if ( is_admin() && ( $block->is_preview() || $block->is_empty() ) ) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :

	$rows = get_field('links');

	
	if( ! empty( $rows ) ) {

		echo '<ul>';

		$count = 0;
		

		foreach( $rows as $row ) {
			$classes = 0 == $count ? ' current-menu-item' : '';
			printf( '<li class="location__link%s"><a href="#%s">%s</a></li>', $classes, $row['anchor'], $row['title'] );
			$count++;
		}

		

		echo '</ul>';
		
	}


endif;
// close the block
echo $block->after_render();
