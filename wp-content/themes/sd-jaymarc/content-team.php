<?php
/**
 * The template for displaying single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'post_class', 'remove_hentry_function', 20 );
function remove_hentry_function( $classes ) {
	if( ( $key = array_search( 'no-featured-image-padding', $classes ) ) !== false )
		unset( $classes[$key] );
	return $classes;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article">
		<?php
		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		// do_action( 'generate_before_content' );

		?>
		<div class="featured-image grid-container grid-parent">
			<?php
			printf( '<div><a href="%s" data-fancybox="gallery-%d">%s</a></div>', 
			get_the_post_thumbnail_url( get_the_ID(),  'large' ), 
			get_the_ID(),
			get_the_post_thumbnail( get_the_ID(),  'large' ) 
		);

			$photos = get_field('photos', get_the_ID() );

			if( ! empty( $photos ) ) {

				$images = '';
    
				foreach( $photos as $photo ) {
					$image = wp_get_attachment_image( $photo, 'large' );
					$photo = wp_get_attachment_image_src( $photo, 'large' );
					$images .= sprintf( '<a href="%s" data-fancybox="gallery-%d">%s</a>', $photo[0], get_the_ID(), $image );
				}
			
				printf( '<div class="photos">%s</div>', $images );    
			}
			?>
		</div>

		<?php

		echo '<div class="content">';

		if ( generate_show_entry_header() ) :
			?>
			<header <?php generate_do_attr( 'entry-header' ); ?>>
				<?php
				/**
				 * generate_before_entry_title hook.
				 *
				 * @since 0.1
				 */
				do_action( 'generate_before_entry_title' );

				if ( generate_show_title() ) {
					$params = generate_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}

				// ACF Data

				?>
				<div class="grid">
					<div class="grid__item">
						<div class="position h4"><?php echo get_field('position', get_the_ID()); ?></div>
						<div class="job-title"><?php echo get_field('title', get_the_ID()); ?></div>
					</div>
					<div class="grid__item">
						<?php
						echo team_contact_info();
						?>
					</div>
				</div>
				<?php

				/**
				 * generate_after_entry_title hook.
				 *
				 * @since 0.1
				 *
				 * @hooked generate_post_meta - 10
				 */
				do_action( 'generate_after_entry_title' );
				?>
			</header>
			<?php
		endif;

		/**
		 * generate_after_entry_header hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_post_image - 10
		 */
		do_action( 'generate_after_entry_header' );

		$itemprop = '';

		if ( 'microdata' === generate_get_schema_type() ) {
			$itemprop = ' itemprop="text"';
		}
		?>

		<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>

		<?php
		/**
		 * generate_after_entry_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_footer_meta - 10
		 */
		do_action( 'generate_after_entry_content' );

		echo '</div>';

		/**
		 * generate_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'generate_after_content' );
		?>
	</div>
</article>
