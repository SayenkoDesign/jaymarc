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

	<div class="wrap">
		<div class="background-image">
			<figure>
				<?php echo wp_get_attachment_image(get_field('image'), 'hero'); ?>
			</figure>
		</div>

		<div class="grid-container">
			<header>


				<?php
				$url = get_field('video');

				if (!empty($url)) {

					$link = add_query_arg(array(
						'autoplay' => 1,
						'modestbranding' => 1,
						'rel' => 0
					), $url);

					$icon = _s_get_icon(
						[
							'icon'	=> 'video-play-icon',
							'group'	=> 'theme',
							'class'	=> 'video-play',
							'width' => 76,
							'height' => 76,
							'label'	=> false,
						]
					);
				?>
					<a href="<?php echo $link; ?>" class="pulse" data-fancybox><span><?php echo $icon; ?></span></a>
				<?php
				}
				?>
				<h1><?php the_field('title'); ?></h1>

				<?php

				$text = get_field('text');
				echo _s_format_string( $text, 'div', ['class' => 'hero-text' ]);

				$link = get_field('button');
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

			</header>
		</div>

	</div>

<?php
endif;
// close the block
echo $block->after_render();
