<?php

use \App\ACF_Block;

$block = new ACF_Block($args);

/* $block->add_render_attribute(
	'block', 'class', [
	   'alignfull',
		]
	);
 */




// Open the block
echo $block->before_render();

if ($block->is_preview() && $block->is_empty()) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :
?>

	<div class="grid">

		<div class="grid-item grid-item-left">
			<header>
				<h2><?php the_field('title_left'); ?></h2>
			</header>
			<div class="grid-item-wrapper">
				<div class="background-image">
					<figure>
						<?php echo wp_get_attachment_image(get_field('image_left'), 'large'); ?>
					</figure>
				</div>

				<div class="overlay">
					<div class="text">
						<?php the_field('text_left'); ?>
						<?php
						$link = get_field('button_left');
						if ($link) :
							$link_url = $link['url'];
							$link_title = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self';
						?>
							<div class="acf-button-wrapper">
								<a class="acf-button acf-button-large" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
							</div>
						<?php endif;
						?>
					</div>
				</div>

			</div>
		</div>

		<div class="grid-item grid-item-right">
			<header>
				<h2><?php the_field('title_right'); ?></h2>
			</header>
			<div class="grid-item-wrapper">
				<div class="background-image">
					<figure>
						<?php echo wp_get_attachment_image(get_field('image_right'), 'large'); ?>
					</figure>
				</div>

				<div class="overlay">
					<div class="text">
						<?php the_field('text_right'); ?>
						<?php
						$link = get_field('button_right');
						if ($link) :
							$link_url = $link['url'];
							$link_title = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self';
						?>
							<div class="acf-button-wrapper">
								<a class="acf-button acf-button-large" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
							</div>
						<?php endif;
						?>
					</div>
				</div>

			</div>
		</div>
	</div>

<?php
endif;
// close the block
echo $block->after_render();
