<?php

use \App\ACF_Block;

$block = new ACF_Block($args);


// Open the block
echo $block->before_render();

if ($block->is_preview() || $block->is_empty()) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :
?>
	
			<div class="grid">

			<div class="grid__column grid__column--left">
				<h2 class="border-bottom"><?php the_field('title');?></h2>

				<?php
				the_field('text');
				?>
			</div>
			<div class="grid__column grid__column--right">
				<div class="businesses">
				<?php
				$businesses = get_field('businesses');

				$businesses = nl2li( $businesses );

				printf( '<ul>%s</ul>', $businesses );
				?>
				</div>
			</div>
			</div>
		<?php
endif;
// close the block
echo $block->after_render();
