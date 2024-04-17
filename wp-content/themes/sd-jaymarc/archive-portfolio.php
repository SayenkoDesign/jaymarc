<?php

/**
 * The template for displaying Archive pages.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_filter('generate_show_post_navigation', '__return_false');

get_header(); ?>

<div <?php generate_do_attr('content'); ?>>
	<main <?php generate_do_attr('main'); ?>>
		<?php
		/**
		 * generate_before_main_content hook.
		 *
		 * @since 0.1
		 */
		do_action('generate_before_main_content');

		/**
		 * generate_archive_title hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_archive_title - 10
		 */
		do_action('generate_archive_title');

		get_template_part('template-parts/portfolio', 'filters');

		echo '<div class="locations">';

		echo '<div class="locations-wrap">';

		echo '<div class="facetwp-template">';

		if (generate_has_default_loop()) {

			if (have_posts()) :



				/**
				 * generate_before_loop hook.
				 *
				 * @since 3.1.0
				 */
				do_action('generate_before_loop', 'archive');




				while (have_posts()) :

					the_post();

					get_template_part('content', 'portfolios');

				endwhile;


				/**
				 * generate_after_loop hook.
				 *
				 * @since 2.3
				 */
				do_action('generate_after_loop', 'archive');

			else :

				//generate_do_template_part('none');

				echo '<p>No results found.</p>';

			endif;
		}

		echo '</div>';

		echo facetwp_display('facet', 'pager_');

		echo '</div>';

		echo '<div class="map">';

		echo facetwp_display('facet', 'map');

		echo '</div>';

		echo '</div>';


		/**
		 * generate_after_main_content hook.
		 *
		 * @since 0.1
		 */
		do_action('generate_after_main_content');
		?>
	</main>
</div>

<?php
/**
 * generate_after_primary_content_area hook.
 *
 * @since 2.0
 */
do_action('generate_after_primary_content_area');

generate_construct_sidebars();

get_footer();
