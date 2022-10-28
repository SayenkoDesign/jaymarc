<?php
// Tabs

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

$close = _s_get_icon(
	[
		'icon'	=> 'close',
		'group'	=> 'theme',
		'class'	=> 'close',
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

];


$post_id = get_field('post');

if (have_rows('tabs', $post_id)) : ?>

	<div class="slick-wrapper">
		<div class="slick-slider invisible">

			<div class="slick-close"><a href><?php echo $close; ?></a></div>

			<div class="slick" data-slick="<?php echo esc_attr(json_encode($data_slick)); ?>">

				<?php while (have_rows('tabs', $post_id)) : the_row(); ?>

					<div class="slide">
						<div class="slick-content">
							<div class="icon">
								<?php echo wp_get_attachment_image(get_sub_field('icon'), 'medium'); ?>
							</div>
							<h3><?php echo get_row_index(); ?>. <?php the_sub_field('title'); ?></h3>
							<h4><?php the_sub_field('subtitle'); ?></h4>
							<div class="">
								<?php the_sub_field('text'); ?>
							</div>
						</div>

					</div>

				<?php endwhile; ?>

			</div>
		</div>
	</div>

<?php endif;
