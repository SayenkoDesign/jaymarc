<?php

/**
 * The template for displaying posts within the loop.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('grid-container'); ?> <?php generate_do_microdata('article'); ?>>
	<div class="inside-article">
		<?php
		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		//do_action( 'generate_before_content' );

		if (generate_show_entry_header()) :
		?>
			<header class="entry-header">

				<div>
						<?php
						/**
						 * generate_before_entry_title hook.
						 *
						 * @since 0.1
						 */
						do_action('generate_before_entry_title');

						if (generate_show_title()) {
							$params = generate_get_the_title_parameters();

							the_title($params['before'], $params['after']);

							$area = _s_get_primary_term('area');
							if (!empty($area)) {
								printf('<h4>%s</h4>', $area->name);
							}
						}

						/**
						 * generate_after_entry_title hook.
						 *
						 * @since 0.1
						 *
						 * @hooked generate_post_meta - 10
						 */
						do_action('generate_after_entry_title');
						?>
					</div>
					<div>
						<?php
						get_template_part('template-parts/home', 'share');
						?>
					</div>
			</header>
		<?php
		endif;

		get_template_part('template-parts/portfolio', 'gallery');

		/**
		 * generate_after_entry_header hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_post_image - 10
		 */
		do_action('generate_after_entry_header');

		$itemprop = '';

		if ('microdata' === generate_get_schema_type()) {
			$itemprop = ' itemprop="text"';
		}

		?>
		<div class="entry">
			<div class="entry-content" <?php echo $itemprop; // phpcs:ignore -- No escaping needed. 
										?>>
				
				<h2 class="border-bottom">Description</h2>
				<?php
				the_content();

				$out = '';

				$architect = get_field('architect');

				if( ! empty( $architect ) ) {
					$out .= sprintf('<li>Architect: %s</li>', $architect );
				}

				$interior_designer = get_field('interior_designer');

				if( ! empty( $interior_designer ) ) {
					$out .= sprintf('<li>Interior Designer: %s</li>', $interior_designer );
				}

				if( ! empty( $out ) ) {
					printf( '<ul class="specs">%s</ul>', $out );
				}
				

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __('Pages:', 'generatepress'),
						'after'  => '</div>',
					)
				);
				?>
			</div>
			<div class="entry-details">
				<?php
				$out = '';

				$style = _s_get_primary_term('style');

				if( ! empty( $style ) ) {
					$out .= sprintf('<li><strong>Style:</strong> %s</li>', $style->name );
				}

				$status = _s_get_primary_term('home_type');

				if( ! empty( $status ) ) {
					$out .= sprintf('<li><strong>status:</strong> %s</li>', $status->name );
				}

				if( ! empty( $out ) ) {
					printf( '<h2 class="border-bottom">Details</h2><ul class="specs">%s</ul>', $out );
				}
				?>
			</div>
		</div>
		<?php

		/**
		 * generate_after_entry_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_footer_meta - 10
		 */
		do_action('generate_after_entry_content');

		/**
		 * generate_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action('generate_after_content');
		?>
	</div>
</article>