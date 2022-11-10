<?php
/**
 * The template for displaying Archive pages.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'generate_before_main_content', function() {
    add_filter('generate_show_post_navigation', '__return_false');

});

add_action('generate_before_loop', function(){
        ?><div class="facetwp-template"><?php
});

add_action('generate_after_loop', function(){
    ?></div><?php
});

add_action( 'generate_after_main_content', function() {
        echo facetwp_display('facet', 'pager_');    
});


add_action('generate_after_archive_title', function() {
	printf('<div class="filter">%s</div>', facetwp_display('facet', 'video_category'));
}, 11 );

get_header(); ?>

	<div <?php generate_do_attr( 'content' ); ?>>
		<main <?php generate_do_attr( 'main' ); ?>>
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

						//generate_do_template_part( 'archive' );

						get_template_part( 'content', 'video' );

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
