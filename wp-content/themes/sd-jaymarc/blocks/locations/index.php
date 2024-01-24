<?php

use \App\ACF_Block;

$block = new ACF_Block($args);


// Open the block
echo $block->before_render();

if ($block->is_preview() || $block->is_empty()) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :
?>
<div class="grid-container">
	
		<?php

		$locations = get_field('locations'); 

		$args = array(
			'post_type' => 'location',
			'order' => 'ASC',
			'orderby' => 'title',
			'posts_per_page' => -1,
			'no_found_rows' => true,
		);

		if (!empty($locations)) {
			$args['orderby'] = 'post__in';
			$args['post__in'] = $locations;
			$args['posts_per_page'] = count($locations);
		}
	
	
		
		// Use $loop, a custom variable we made up, so it doesn't overwrite anything
		$loop = new WP_Query($args);
		
		// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
		// don't want to use $wp_query, use our custom variable instead.
		if ($loop->have_posts()) :
		?>
			<div class="grid">

			<div class="grid__column grid__column--left">
				<h2 class="border-bottom"><?php the_field('title');?></h2>
			</div>
			<div class="grid__column grid__column--right">
				<div class="locations">
				<?php
				while ($loop->have_posts()) : $loop->the_post();
				?>
					<div class="location">
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
						printf( '<a href="%s"><span class="icon">%s</span>%s</a>', get_permalink( get_the_ID() ), $icon, get_the_title( get_the_ID() ) ); 
						?>
					</div>
				<?php
				endwhile;
				?>
				</div>
			</div>
			</div>
		<?php
		endif;
		?>
</div>
		<?php
endif;
// close the block
echo $block->after_render();
