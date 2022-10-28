<?php
$post_ids = get_field( 'related_homes' );

if (empty($post_ids)) {
	return false;
}

$args = array(
	'post_type' => 'home',
	'order' => 'ASC',
	'orderby' => 'post__in',
	'post__in' => $post_ids,
	'posts_per_page' => count($post_ids)
);

// Use $loop, a custom variable we made up, so it doesn't overwrite anything
$loop = new WP_Query($args);

// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
// don't want to use $wp_query, use our custom variable instead.
if ($loop->have_posts()) :
	$total = $loop->found_posts; 
?>
	<div class="related-homes<?php echo ( $total > 3) ? ' slick' : '';?>">
		<?php
		while ($loop->have_posts()) : $loop->the_post();
			$i = $loop->current_post;
			echo ( $total  && (0 == $i % 3) ) ? '<div class="group">' : '';
		?>
			<div class="home">
				<div class="home__thumbnail">
					<div class="background-image">
						<figure>
							<?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?>
						</figure>
					</div>
				</div>
				<div class="home__content">
					<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
					<?php
					$beds = get_field('beds');
					$baths = get_field('baths');
					$sqft = sprintf( '%s', number_format( get_field('square_feet') ) );
					?>
					<ul class="specs">
						<li class="beds"><?php echo $beds;?><span>Beds</span></li>
						<li class="baths"><?php echo $baths;?><span>Baths</span></li>
						<li class="sqft"><?php echo $sqft;?><span>Sq. Ft.</span></li>
					</ul>
				</div>
			</div>
		<?php
			echo ( $total && ($loop->post_count == $i || 2 == $i % 3) ) ? '</div>' : '';
		endwhile;
		?>
	</div>
<?php
endif;
wp_reset_postdata();
