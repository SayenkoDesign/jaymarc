<?php

use \App\ACF_Block;

$block = new ACF_Block($args);

$previous = wp_unique_id('prev-');
$next     = wp_unique_id('next-');

$previous_icon = _s_get_icon(
	[
		'icon'	=> 'arrow-line-left',
		'group'	=> 'theme',
		'class'	=> 'previous',
		'width' => 28,
		'height' => 14,
		'label'	=> false,
	]
);

$next_icon = _s_get_icon(
	[
		'icon'	=> 'arrow-line-right',
		'group'	=> 'theme',
		'class'	=> 'previous',
		'width' => 28,
		'height' => 14,
		'label'	=> false,
	]
);

$data_slick = [
	'infinite'       => true,
	'slidesToShow'   => 4,
	'slidesToScroll' => 4,
	'dots'           => false,
	'arrows'         => true,
	'prevArrow'      => sprintf("#%s",  $previous),
	'nextArrow'      => sprintf("#%s",  $next),
	
	'responsive'     => [
        [
            'breakpoint' => 640,
            'settings'   => [
				'slidesToShow'   => 2,
				'slidesToScroll' => 2,
            ],
        ],
    ]


];

$buttons = sprintf( '<div class="slick-arrows">
<button id="%s" class="slick-arrow" aria-label="Previous" type="button">%s<span class="screen-reader-text">Previous</span></button>
<div class="slick-counter"></div>
<button id="%s" class="slick-arrow" aria-label="Next" type="button">%s<span class="screen-reader-text">Next</span></button>
</div>', $previous, $previous_icon, $next, $next_icon );


// Open the block
echo $block->before_render();

if ( is_admin() && ( $block->is_preview() || $block->is_empty() ) ) :
	get_template_part(sprintf('blocks/%s/%s', $block->get_name(), 'placeholder'), NULL, ['block' => $block]);
else :

	$rows = get_field('logos');

	
	if( ! empty( $rows ) ) {

		echo $buttons;
		?>
		<div class="logos slick" data-slick="<?php echo esc_attr( json_encode( $data_slick ) );?>">
		<?php

		foreach( $rows as $row ) {
			printf( '<div class="logo__item"><div class="logo__wrapper">%s</div></div>', wp_get_attachment_image( $row, 'thumbnail' ) );
		}

		echo '</div><!-- ./logos -->';
		
	}


endif;
// close the block
echo $block->after_render();
