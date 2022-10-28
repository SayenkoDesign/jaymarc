<?php
$post_id = get_field('featured_home', 'home_archive');

if (empty($post_id)) {
	return false;
}

$args = array(
	'post_type' => 'home',
	'p' => $post_id
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

// Use $loop, a custom variable we made up, so it doesn't overwrite anything
$loop = new WP_Query($args);

// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
// don't want to use $wp_query, use our custom variable instead.
if ($loop->have_posts()) :

	$container_class = 'featured-home';
?>
<div class="featured-home-container">
	

		<?php
		while ($loop->have_posts()) : $loop->the_post();
		?>
		<div class="featured-home">
			<div class="<?php echo $container_class; ?>__column">
				<div class="<?php echo $container_class; ?>__thumbnail">
					<div class="background-image">
						<figure>
							<?php 
							$featured_photo = get_field('featured_photo', 'home_archive' );
							echo  wp_get_attachment_image( $featured_photo, 'large' );
							?>
						</figure>
					</div>
				</div>
			</div>
			
			<div class="<?php echo $container_class; ?>__column">
				<div class="<?php echo $container_class; ?>__content">
					<h2>Featured <br />Model Home</h2>
					<?php
					echo featured_home_days();


					$location   = get_field('location');

					$title = _s_format_string(get_the_title(), 'h3');

					printf(
						'<div class="featured-location">%s%s<h4>%s, %s</h4></div>',
						$icon,
						$title,
						_s_get_primary_term('area')->name,
						$location['state_short']
					);
					?>

					<div class="acf-button-wrapper">
						<a href="<?php the_permalink(); ?>" class="acf-button reversed">more info</a>
					</div>
				</div>
			</div>
			</div>
			
		<?php
		endwhile;
		?>

	</div>
<?php
endif;
wp_reset_postdata();
