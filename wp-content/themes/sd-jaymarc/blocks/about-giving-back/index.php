<?php



use \App\ACF_Block;

$block = new ACF_Block($args);

// Open the block
echo $block->before_render();

if (is_admin() && ($block->is_preview() || $block->is_empty())) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :

	$image = get_field('image');
	$content = get_field('content');

	if (!empty($image)) :
?>

		<div class="image">

			<?php

			printf('<div class="image__wrap">%s</div>',  wp_get_attachment_image($image, 'wide'));

			if (!empty($content)) {
			?>
				<div class="content grid-container">
					<div class="content__wrap">
						<div class="content__inner">
							<?php the_field('content'); ?>
						</div>
					</div>
				</div>

			<?php
			}
			?>
		</div>
<?php
	endif;

endif;

// close the block
echo $block->after_render();
