<?php
use \App\ACF_Block;

$block = new ACF_Block( $args );

/* $block->add_render_attribute(
	'block', 'class', [
	   'alignfull',
		]
	);
 */




// Open the block
echo $block->before_render();

if( $block->is_preview() && $block->is_empty() ) :
	get_template_part( sprintf('blocks/%s/%s', $block->get_name(), 'placeholder' ), NULL, [ 'block' => $block ]  );
else :	
	?>

<div class="stack">
	<picture>
		<?php
		$image_mobile = wp_get_attachment_image_src(get_field('image_mobile'), 'hero_mobile');
		if (!empty($image_mobile)) {
			printf('<source 
		srcset="%s"
		media="(max-width: 1023px)"
	/>', $image_mobile[0]);
		}
		?>
		<?php echo wp_get_attachment_image(get_field('image'), 'hero'); ?>
	</picture>

	<div class="wrap">
	<div class="grid-container">
	<header>
		<?php
		$url = get_field('video');

		if ( ! empty( $url ) ) {

			$link = add_query_arg( array(
				'autoplay' => 1,
				'modestbranding' => 1,
				'rel' => 0
			), $url );
			
			$icon = _s_get_icon(
				[
					'icon'	=> 'video-play-icon',
					'group'	=> 'theme',
					'class'	=> 'video-play',
					'width' => 76,
					'height'=> 76,
					'label'	=> false,
				]
			);
			?>
			<a href="<?php echo $link;?>" class="pulse" data-fancybox><span><?php echo $icon;?></span></a>	
		<?php
		}
		?>
		<h1><span><?php the_field('subtitle');?></span> <?php the_field('title');?></h1>
		<?php the_field('text');?>

		<?php
		echo _s_get_icon(
			[
				'icon'	=> 'five-star-review',
				'group'	=> 'theme',
				'class'	=> 'five-star-review',
				'width' => 237,
				'height' => 38,
				'label'	=> false,
			]
		);
		
		?>
		
		
	</header>
	</div>
	</div>
	
</div>

<?php
endif;
// close the block
echo $block->after_render();