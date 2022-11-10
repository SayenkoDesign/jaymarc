<?php

/**
 * The template for displaying posts within the loop.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}


add_filter('generate_featured_image_output', function ($output) {

	$video = get_field('video');

	if (!empty($video)) {
		$url = sprintf('<a href="%s?autoplay=1&amp;modestbranding=1&amp;rel=0" class="pulse" data-fancybox=""><span><svg class="video-play-icon" width="76" height="76" role="img" aria-hidden="true" focusable="false" viewBox="0 0 76 76" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="3" transform="translate(3 3)"><circle cx="35" cy="35" r="36.5"></circle><path d="m52 36-24 12v-24z"></path></g></svg></span></a>', $video);
	}

	return sprintf( // WPCS: XSS ok.
		'<div class="post-image">
                %1$s%2$s
         </div>',
		$url,
		get_the_post_thumbnail(
			get_the_ID(),
			apply_filters('generate_page_header_default_size', 'full'),
			array(
				'itemprop' => 'image',
			)
		)
	);
});

?>
<article id="<?php echo sanitize_title_with_dashes( get_the_title() );?>" <?php post_class(); ?> <?php generate_do_microdata('article'); ?>>
	<div class="inside-article">
		<?php
		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		do_action('generate_before_content');

		if (generate_show_entry_header()) :
		?>
			<header <?php generate_do_attr('entry-header'); ?>>
				<?php
				/**
				 * generate_before_entry_title hook.
				 *
				 * @since 0.1
				 */
				do_action('generate_before_entry_title');

				printf('<h2 class="entry-title">%s</h2>', get_the_title());

				/**
				 * generate_after_entry_title hook.
				 *
				 * @since 0.1
				 *
				 * @hooked generate_post_meta - 10
				 */
				do_action('generate_after_entry_title');
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
		do_action('generate_after_entry_header');

		$itemprop = '';

		if ('microdata' === generate_get_schema_type()) {
			$itemprop = ' itemprop="text"';
		}

		?>
		<div class="entry-summary" <?php echo $itemprop; // phpcs:ignore -- No escaping needed. 
									?>>
			<?php the_excerpt(); ?>
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