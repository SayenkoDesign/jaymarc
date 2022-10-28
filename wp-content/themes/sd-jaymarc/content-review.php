<?php
/**
 * The template for displaying single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article">
		<?php
		/*
		initials
		content
		type
		*/
		?>
		<div class="thumbnail">
			<?php
			if( has_post_thumbnail() ) {
				the_post_thumbnail( 'thumbnail' );
			} else {
				printf( '<div class="initials">%s</div>', get_field( 'initials' ) );
			}
			?>
		</div>
		<div class="content">
			<blockquote>
				<?php the_field( 'content' );?>
				<?php
				$title = get_the_title();
				$type = get_field( 'type' );
				if( ! empty( $type ) ) {
					$type = wpautop( $type );
				}
				printf( '<cite><p>- %s</p>%s</cite>', $title, $type );
				?>
			</blockquote>
			
		</div>
	</div>
</article>
