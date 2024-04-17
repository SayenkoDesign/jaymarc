<?php
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
	'dots'           => false,
	'arrows'         => true,
	'prevArrow'      => sprintf('<button class="slick-prev">%s</button>',  $previous),
	'nextArrow'      => sprintf('<button class="slick-next">%s</button>',  $next),
	'speed' 	     => 0,
	'responsive'     => [
		[
            'breakpoint' => 1199,
            'settings'   => [
				'dots'   => true,
				'arrows' => false,
            ],
        ],
    ]

];

?>
<div class="home-plans">
	<?php	
	$photos = get_field('floor_plans');
	
	if( ! empty( $photos ) ) {

		?>

		<h2 class="border-bottom">Floor Plans</h2>

		<div class="slick" data-slick="<?php echo esc_attr(json_encode($data_slick)); ?>">
		<?php
		
		foreach( $photos as $photo ) {
			$image = wp_get_attachment_image_src( $photo, 'large' );
			printf( '<a href="%s" data-fancybox="plans">%s</a>', $image[0], wp_get_attachment_image( $photo, 'large' ) );
		}

		echo '</div>';
		
	}
	?>
</div>