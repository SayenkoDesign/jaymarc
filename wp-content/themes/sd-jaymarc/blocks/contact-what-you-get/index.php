<?php

use \App\ACF_Block;

$block = new ACF_Block($args);


// Open the block
echo $block->before_render();

if ($block->is_preview() || $block->is_empty()) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :
?>

	<?php if (have_rows('list')) : ?>
		<div class="wrap">
		<h2><?php the_field('title'); ?></h2>
		<ul class="list">
			<?php while (have_rows('list')) : the_row(); ?>
				<?php
				$icon = _s_get_icon(
					[
						'icon'	=> 'checkmark',
						'group'	=> 'theme',
						'class'	=> 'checkmark',
						'width' => 18,
						'height' => 15,
						'label'	=> false,
					]
				);
				printf('<li><span class="icon">%s</span>%s</li>', $icon, get_sub_field('item'));
				?>
			<?php
			endwhile;
			?>
		</ul>
		</div>
<?php
	endif;

endif;
// close the block
echo $block->after_render();
