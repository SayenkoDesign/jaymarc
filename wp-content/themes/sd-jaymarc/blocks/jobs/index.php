<?php

use \App\ACF_Block;

$block = new ACF_Block($args);


$post_ids = get_field('posts');


$accordion_id = wp_unique_id('accordion-');


// Open the block
echo $block->before_render();

if ($block->is_preview() ) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :

	$args = array(
		'post_type' => 'job',
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



	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query($args);

	// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
	// don't want to use $wp_query, use our custom variable instead.
	if ($loop->have_posts()) : ?>

		<div class="accordion" id="<?php echo $accordion_id; ?>">
			<?php
			while ($loop->have_posts()) : $loop->the_post();

			?>
				<div class="accordion__item">
					<h3 class="accordion__title">
						<?php the_title() ?>
					</h3>
					<div class="accordion__content">
						<div class="acf-button-wrapper"><a class="acf-button button-small button-black job-apply" data-job="<?php the_title();?>" href="#apply">Apply Now</a></div>
						
						<?php
						$date_posted = get_field('date_posted', get_the_ID() );
						if( ! empty( $date_posted ) ) {
							printf( '<p class="date-posted">Poted Date: %s</p>', $date_posted );
						}
						?>
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

	<script>
		(function(document, window, $) {

			// Hiding the panel content. If JS is inactive, content will be displayed
			$('.accordion__content').hide();

			$( '.job-apply' ).on( "click", function() {
				// console.log($(this).data("job"));
				var job = $(this).data("job");
				$(".populate_job select option").filter(function() {
					console.log($(this).text());
					console.log(job);
					return $(this).text() == job;
				}).prop('selected', true);
			});

			

		}(document, window, jQuery));
	</script>
<?php
endif;
// close the block
echo $block->after_render();
