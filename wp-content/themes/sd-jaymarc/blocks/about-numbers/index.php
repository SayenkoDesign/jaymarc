<?php

use \App\ACF_Block;

$block = new ACF_Block($args);

// Open the block
echo $block->before_render();

if ($block->is_preview() || $block->is_empty()) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :
?>

	
		<?php
		if( have_rows('rows' ) ): ?>
<div class="wrap">
			<ul class="numbers">
		
			<?php while( have_rows('rows' ) ) : the_row(); ?>
				<li><div>
				<h3><?php the_sub_field('title'); ?></h3>
				<p><?php the_sub_field('text'); ?></p>
		</div></li>
		
			<?php endwhile; ?>
		
			</ul>
			</div>
		<?php endif;
		?>
	

<?php
endif;
// close the block
echo $block->after_render();
