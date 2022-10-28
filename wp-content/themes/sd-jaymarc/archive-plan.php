<?php
/**
 * The template for displaying Archive pages.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div <?php generate_do_attr( 'content' ); ?>>
		<main <?php generate_do_attr( 'main' ); ?>>

			<div class="filters">
			<?php
			printf( '<div class="filter">%s</div>', facetwp_display( 'facet', 'sqft' ) );
			printf( '<div class="filter">%s</div>', facetwp_display( 'facet', 'width' ) );
			printf( '<div class="filter">%s</div>', facetwp_display( 'facet', 'depth' ) );
			printf( '<div class="filter">%s</div>', facetwp_display( 'facet', 'beds' ) );
			printf( '<div class="filter">%s</div>', facetwp_display( 'facet', 'baths' ) );
			?>
			<div class="acf-button-wrapper"><a class="acf-button reversed" href="javascript:;" onclick="FWP.reset()">Clear</a></div>
			</div>


			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			if ( generate_has_default_loop() ) {
				if ( have_posts() ) :

					/**
					 * generate_archive_title hook.
					 *
					 * @since 0.1
					 *
					 * @hooked generate_archive_title - 10
					 */
					do_action( 'generate_archive_title' );

					/**
					 * generate_before_loop hook.
					 *
					 * @since 3.1.0
					 */
					do_action( 'generate_before_loop', 'archive' );

					while ( have_posts() ) :

						the_post();

						// generate_do_template_part( 'archive' );
						get_template_part( 'content', 'plans' );

					endwhile;

					/**
					 * generate_after_loop hook.
					 *
					 * @since 2.3
					 */
					do_action( 'generate_after_loop', 'archive' );

				else :

					generate_do_template_part( 'none' );

				endif;
			}

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

	get_footer();
