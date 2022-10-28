<?php

use \App\ACF_Block;

$block = new ACF_Block($args);

$post_ids = get_field('posts');

$filters = '';

$accordion_id = wp_unique_id('accordion-');

$filters_id = wp_unique_id('filters-');

// Open the block
echo $block->before_render();

if ($block->is_preview() || empty($post_ids) ) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :

	$args = array(
		'post_type' => 'school',
		'order' => 'ASC',
		'posts_per_page' => -1,
		'no_found_rows' => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'fields' => 'ids'
	);

	

	if (!empty($post_ids)) {
		$args['orderby'] = 'post__in';
		$args['post__in'] = $post_ids;
		$args['posts_per_page'] = count($post_ids);
	}

	$terms = [];

	foreach( $post_ids as $post_id ) {
		$term_list = get_the_terms( $post_id, 'school_type' ); 
		$terms[$term_list[0]->term_id] = $term_list[0];
	}

	if( ! empty( $terms ) ) {
		$count = 0;
		foreach ( $terms as $term ) {
				$class = 0 == $count ? 'active' : '';
				$filters .= sprintf(
					'<li data-filter=".%s" class="%s"><span class="filter">%s</span></li>',
					esc_attr($term->slug),
					$class,
					esc_attr($term->name)
				);	
				
				$count++;
		}

		$filters = sprintf('<ul class="filter-button-group" id="%s">%s</ul>', $filters_id, $filters);
	}


	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query($args);

	// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
	// don't want to use $wp_query, use our custom variable instead.
	if ($loop->have_posts()) : ?>

	<?php
	if (!empty($filters)) {
		echo $filters;
	}
	?>

		<div class="schools" id="<?php echo $accordion_id; ?>">
			<?php
			while ($loop->have_posts()) : $loop->the_post();

			$term_classnames = '';
			$term_list = wp_get_post_terms(get_the_ID(), 'school_type');
			foreach( $term_list as $t) {
				$term_classnames .= ' ' . $t->slug;
			}
			?>
				<div class="school__item<?php echo $term_classnames; ?>">
					<div class="school__rating"><span><?php the_field('rating', get_the_ID() );?></span>/10</div>
					<h5 class="school__title">
						<?php the_title();
						the_field('description', get_the_ID());
						?>

					</h5>
				</div>
			<?php

			endwhile;
			?>
		</div>
	<?php
	endif;
	wp_reset_postdata();
	?>

	<?php
	if (!empty($filters)) :
	?>
		<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
	<?php
	endif;
	?>
	<script>
		(function(document, window, $) {

			// Hiding the panel content. If JS is inactive, content will be displayed
			<?php
			if (!empty($filters)) :
			?>
				$('#<?php echo $accordion_id; ?>').isotope({
					itemSelector: '.school__item',
					transitionDuration: 0,
					<?php
					if( ! empty( $terms ) ) {
						$term = array_shift($terms);
						printf('filter: ".%s"', $term->slug );
					}
					?>
				});

				// filter items on button click
				$('#<?php echo $filters_id; ?>').on('click', 'li', function() {
					var filterValue = $(this).attr('data-filter');
					$('#<?php echo $accordion_id; ?>').isotope({
						filter: filterValue
					});
					$('#<?php echo $filters_id; ?> li').removeClass('active');
					$(this).addClass('active');
				});
			<?php
			endif;
			?>

		}(document, window, jQuery));
	</script>
<?php
endif;
// close the block
echo $block->after_render();
