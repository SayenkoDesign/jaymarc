<?php

use \App\ACF_Block;

$block = new ACF_Block($args);

$show_filters  = strtolower(get_field('filters'));
$terms    = get_field('terms');
$post_ids = get_field('posts');

$filters = '';

$accordion_id = wp_unique_id('accordion-');

$filters_id = wp_unique_id('filters-');

// Open the block
echo $block->before_render();

if ($block->is_preview() || $block->is_empty() || (empty($post_ids) && empty($terms))) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :

	$args = array(
		'post_type' => 'faq',
		'order' => 'ASC',
		'posts_per_page' => -1,
		'no_found_rows' => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'fields' => 'ids'
	);

	if (!empty($terms)) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'topic',   // taxonomy name
				'field' => 'term_id',           // term_id, slug or name
				'terms' => $terms,                  // term id, term slug or term name
			)
		);

		foreach ($terms as $id) {
			$term = get_term( $id , 'topic' );
			if( $term->count ) {
				$filters .= sprintf(
					'<li data-filter=".%s"><span class="filter">%s</span></li>',
					esc_attr($term->slug),
					esc_attr($term->name)
				);
			}
			
		}

		$filters = sprintf('<ul class="filter-button-group" id="%s"><li class="active" data-filter="*"><span class="filter">All</span></li>%s</ul>', $filters_id, $filters);
	}

	if (!empty($post_ids)) {
		$args['orderby'] = 'post__in';
		$args['post__in'] = $post_ids;
		$args['posts_per_page'] = count($post_ids);
	}



	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query($args);

	// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
	// don't want to use $wp_query, use our custom variable instead.
	if ($loop->have_posts()) : ?>

	<?php
	if ( 'yes' == $show_filters && !empty($filters)) {
		echo $filters;
	}
	?>

		<div class="accordion" id="<?php echo $accordion_id; ?>">
			<?php
			while ($loop->have_posts()) : $loop->the_post();

			$term_classnames = '';
			$term_list = wp_get_post_terms(get_the_ID(), 'topic');
			foreach( $term_list as $t) {
				$term_classnames .= ' ' . $t->slug;
			}
			?>
				<div class="accordion__item<?php echo $term_classnames; ?>">
					<h3 class="accordion__title">
						<?php the_title() ?>
					</h3>
					<div class="accordion__content">
						<?php the_content(); ?>
					</div>
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
	if ('yes' == $show_filters && !empty($filters)) :
	?>
		<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
	<?php
	endif;
	?>
	<script>
		(function(document, window, $) {

			// Hiding the panel content. If JS is inactive, content will be displayed
			$('.accordion__content').hide();

			<?php
			if ('yes' == $show_filters && !empty($filters)) :
			?>
				$('#<?php echo $accordion_id; ?>').isotope({
					itemSelector: '.accordion__item',
					transitionDuration: 0
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
