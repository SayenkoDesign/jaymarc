<?php

$image = get_field('image');
$url = get_field('url');

use \App\ACF_Block;

$block = new ACF_Block($args);

// Open the block
echo $block->before_render();

if ($block->is_preview() || $block->is_empty()) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :
?>

	<div class="image">

		<?php
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
			<div class="image-wrap">
				<a href="<?php echo $link; ?>" class="pulse" data-fancybox><span><?php echo $icon; ?></span></a>
			<?php
		}

		echo wp_get_attachment_image($image, 'large');

		if (!empty($url)) {
			?>
			</div>

		<?php
		}
		?>
	</div>
<?php

endif;

// close the block
echo $block->after_render();
