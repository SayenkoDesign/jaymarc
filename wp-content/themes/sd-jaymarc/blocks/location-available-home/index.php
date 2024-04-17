<?php
use \App\ACF_Block;

$block = new ACF_Block( $args );

// Open the block
echo $block->before_render();

$post_ids = get_field('posts');


$args = array(
	'post_type' => 'home',
	'order' => 'ASC',
	'orderby' => 'post__in',
	'post__in' => $post_ids,
	'posts_per_page' => count($post_ids),
	'facetwp' => false,
);

$previous = _s_get_icon(
	[
		'icon'	=> 'previous',
		'group'	=> 'theme',
		'class'	=> 'previous',
		'width' => 66,
		'height'=> 66,
		'label'	=> false,
	]
);


$next = _s_get_icon(
	[
		'icon'	=> 'next',
		'group'	=> 'theme',
		'class'	=> 'next',
		'width' => 66,
		'height'=> 66,
		'label'	=> false,
	]
);

$data_slick = [
	'infinite'       => true,
	'slidesToShow'   => 3,
	'slidesToScroll' => 1,
	'dots'           => false,
	'arrows'         => true,	
	'prevArrow'      => sprintf( '<button class="slick-prev">%s</button>',  $previous ),
    'nextArrow'      => sprintf( '<button class="slick-next">%s</button>',  $next ),
	'responsive'     => [
		[
            'breakpoint' => 1199,
            'settings'   => [
				'dots'   => true,
				'arrows' => false,
            ],
        ],
        [
            'breakpoint' => 768,
            'settings'   => [
				'slidesToShow'   => 2,
				'slidesToScroll' => 2,
            ],
        ],
		[
            'breakpoint' => 680,
            'settings'   => [
				'slidesToShow'   => 1,
				'slidesToScroll' => 1,
            ],
        ],
    ]


];

if( $block->is_preview() || empty( $post_ids ) ) :
	get_template_part( sprintf('blocks/%s/%s', $block->get_name(), 'placeholder' ), NULL, [ 'block' => $block ]  );
else :	

// Use $loop, a custom variable we made up, so it doesn't overwrite anything
$loop = new WP_Query($args);

// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
// don't want to use $wp_query, use our custom variable instead.
if ($loop->have_posts()) :
	$total = $loop->found_posts;

	$container_class = ($total > 3) ? ' slick' : 'grid';
	$data_slick = ( $total > 3) ? sprintf( 'data-slick="%s"', esc_attr( json_encode( $data_slick ) ) ) : '';
?>

	<div class="related-posts">
		<div class="grid-container">
		<h2><?php the_field('title');?></h2>
		<div class="<?php echo $container_class;?>" <?php echo $data_slick;?>>
			<?php
			while ($loop->have_posts()) : $loop->the_post();
			?>
				<div class="<?php echo $container_class; ?>__column">
					<div class="<?php echo $container_class; ?>__thumbnail">
						<div class="background-image">
							<figure>
								<?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
							</figure>
						</div>
					</div>
					<div class="<?php echo $container_class; ?>__content">
						<h3><a href="<?php the_permalink(); ?>" class="link-cover"><?php the_title(); ?></a></h3>
						<?php
						$beds = get_field('beds', get_the_ID());
						$baths = get_field('baths', get_the_ID());
						$sqft = sprintf( '%s', number_format( get_field('square_feet', get_the_ID()) ) );
						?>
						<ul class="features">
							<li class="beds"><?php echo $beds;?> Beds</li>
							<li class="baths"><?php echo $baths;?> Baths</li>
							<li class="sqft"><?php echo $sqft;?> Sq. Ft.</li>
						</ul>
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

endif;

// close the block
echo $block->after_render();