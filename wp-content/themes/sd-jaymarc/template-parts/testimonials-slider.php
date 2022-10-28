<?php
$post_ids = get_field('testimonial');


if (empty($post_ids)) {
	return false;
}

$args = array(
	'post_type' => 'testimonial',
	'order' => 'ASC',
	'orderby' => 'post__in',
	'post__in' => $post_ids,
	'posts_per_page' => count($post_ids),
);


$data_slick = [
	'infinite'       => true,
	'slidesToShow'   => 1,
	'slidesToScroll' => 1,
	'dots'           => true,
	'arrows'         => false,
	// 'speed' 	     => 0,

];

// Use $loop, a custom variable we made up, so it doesn't overwrite anything
$loop = new WP_Query($args);

// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
// don't want to use $wp_query, use our custom variable instead.
if ($loop->have_posts()) :

?>
<section class="portfolio-testimonials"><div class="wrap">

<?php
	$title = get_field('testimonials_title');
	if( ! empty( $title ) ) {
		printf( '<h2>%s</h2>', $title );
	}
	?>
	<div class="testimonials-slider slick" data-slick="<?php echo esc_attr(json_encode($data_slick)); ?>"">
		<?php

		while ($loop->have_posts()) : $loop->the_post();

		?>
			<div class="testimonial">
				<blockquote class="testimonial__text">
					<?php
					echo _s_get_icon(
						[
							'icon'	=> 'quote-mark',
							'group'	=> 'theme',
							'class'	=> 'quote-mark',
							'width' => 35,
							'height' => 22,
							'label'	=> false,
						]
					);
					?>
					<?php echo get_field('text', get_the_ID()); ?>
					<cite class="testimonial__name">
						<?php echo get_the_title(get_the_ID()); ?>
					</cite>
				</blockquote>

				<div class="testimonial__thumbnail">
					<div class="testimonial__background">
						<figure>
							<?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?>

							<?php
							do_action( 'qm/debug', get_the_ID() );
							?>
						</figure>
					</div>

					<?php
					/* $url = get_field('video', get_the_ID());

				if ( ! empty( $url ) ) {
		
					$link = add_query_arg( array(
						'autoplay' => 1,
						'modestbranding' => 1,
						'rel' => 0
					), $url );
					
					$icon = _s_get_icon(
						[
							'icon'	=> 'video-play-icon',
							'group'	=> 'theme',
							'class'	=> 'video-play',
							'width' => 76,
							'height'=> 76,
							'label'	=> false,
						]
					);
					?>
					<a href="<?php echo $link;?>" class="pulse" data-fancybox><?php echo $icon;?></a>	
				<?php
				} */
					?>
				</div>

			</div>
		<?php

		endwhile;

		?>
	</div>
	</div></section>
<?php
endif;
wp_reset_postdata();
