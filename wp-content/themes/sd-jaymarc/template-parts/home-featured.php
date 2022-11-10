<?php
$post_ids = get_field('featured_homes', 'home_archive');

if (empty($post_ids)) {
	return false;
}


$args = array(
	'posts_per_page' => count($post_ids),
	'post_type' => 'home',
	'orderby' => 'post__in',
	'post__in' => $post_ids,
);

$icon = _s_get_icon(
	[
		'icon'	=> 'marker',
		'group'	=> 'theme',
		'class'	=> 'map-marker',
		'width' => 34,
		'height' => 48,
		'label'	=> false,
	]
);

$previous = _s_get_icon(
	[
		'icon'	=> 'previous',
		'group'	=> 'theme',
		'class'	=> 'previous',
		'width' => 66,
		'height' => 66,
		'label'	=> false,
	]
);

$next = _s_get_icon(
	[
		'icon'	=> 'next',
		'group'	=> 'theme',
		'class'	=> 'next',
		'width' => 66,
		'height' => 66,
		'label'	=> false,
	]
);

$data_slick = [
	'infinite'       => true,
	'slidesToShow'   => 1,
	'slidesToScroll' => 1,
	'dots'           => true,
	'arrows'         => true,
	'prevArrow'      => sprintf('<button class="slick-prev">%s</button>',  $previous),
	'nextArrow'      => sprintf('<button class="slick-next">%s</button>',  $next),
	'speed' 	     => 0,
	'responsive'     => [
		[
            'breakpoint' => 1023,
            'settings'   => [
				'dots'   => true,
				'arrows' => false,
            ],
        ],
    ]

];

// Use $loop, a custom variable we made up, so it doesn't overwrite anything
$loop = new WP_Query($args);

// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
// don't want to use $wp_query, use our custom variable instead.
if ($loop->have_posts()) :

	$container_class = 'featured-home';
?>
	<div class="featured-home-container">

		<div class="slick" data-slick="<?php echo esc_attr(json_encode($data_slick)); ?>">


			<?php
			while ($loop->have_posts()) : $loop->the_post();
			?>
				<div class="featured-home">
					<h2>Featured <br />Model Home</h2>
					<div class="featured-home__grid">

						<div class="<?php echo $container_class; ?>__column">
							<div class="<?php echo $container_class; ?>__thumbnail">
								<div class="background-image">
									<figure>
										<?php
										//$featured_photo = get_field('featured_photo', 'home_archive' );
										//echo  wp_get_attachment_image( $featured_photo, 'large' );
										echo get_the_post_thumbnail(get_the_ID(), 'medium');
										?>
									</figure>
								</div>
							</div>
						</div>

						<div class="<?php echo $container_class; ?>__column">
							<div class="<?php echo $container_class; ?>__content">

								<?php
								echo _s_format_string(get_the_title(), 'h3');


								echo featured_home_days(get_the_ID());


								$location   = get_field('location');

								printf(
									'<div class="featured-location">%s<h4>%s</h4></div>',
									$icon,
									get_home_address(get_the_ID())
								);
								?>

								<div class="acf-button-wrapper">
									<a href="<?php the_permalink(); ?>" class="acf-button reversed">more info</a>
								</div>
							</div>
						</div>
					</div>

				</div>

			<?php
			endwhile;
			?>

		</div>

	</div>
<?php
endif;
wp_reset_postdata();
