<?php

use \App\ACF_Block;

$block = new ACF_Block($args);

/*
Name
Title
URL
*/



// Open the block
echo $block->before_render();

if ($block->is_preview() && $block->is_empty()) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :
?>

	<div class="wrap">
		<?php
		printf('<div class="acf-icon">%s</div>',  _s_get_icon(
			[
				'icon'	=> 'instagram',
				'group'	=> 'theme',
				'class'	=> 'instagram',
				'width' => 23,
				'height' => 22,
				'label'	=> false,
			]
		) );
		?>
		<header>
			<h2><?php the_field('title'); ?></h2>
			<h3><?php the_field('name'); ?></h3>

		</header>
		<div class="acf-button-wrapper">
			<a class="acf-button acf-button-large reversed" href="<? the_field('url'); ?>" target="_blank">Follow Us On Instagram</a>
		</div>
	</div>

<?php
endif;
// close the block
echo $block->after_render();
