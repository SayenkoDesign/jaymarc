<?php
$args = array(
	'post_type' => 'team',
	'order' => 'ASC',
	'orderby' => 'menu_order',
	'posts_per_page' => -1,
	'no_found_rows' => true,
	'update_post_meta_cache' => false,
	'update_post_term_cache' => false,
	'fields' => 'ids'
);

// Use $loop, a custom variable we made up, so it doesn't overwrite anything
$loop = new WP_Query($args);

// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
// don't want to use $wp_query, use our custom variable instead.
if ($loop->have_posts()) :
?>
	<div class="facetwp-filters">
		<?php echo do_shortcode( '[facetwp facet="department"]' );?>
	</div>
	
	<div class="grid facetwp-template">
		<?php
		while ($loop->have_posts()) : $loop->the_post();

		?>
			<div class="grid__item">
				<div class="grid__thumbnail">
					<figure>
						<?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?>
					</figure>
				</div>
				<div class="grid__text">
					<h3><?php echo get_the_title(get_the_ID()); ?></h3>
					<div class="position"><?php echo get_field('position', get_the_ID()); ?></div>
					<div class="job-title"><?php echo get_field('title', get_the_ID()); ?></div>
					
					
					<a href="<?php the_permalink();?>" class="link-cover"><span class="screen-reader-text">read bio</span></a>
				</div>
			</div>
		<?php

		endwhile;
		?>
	</div>
<?php
endif;
wp_reset_postdata();
