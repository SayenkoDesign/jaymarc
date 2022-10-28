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
	'slidesToShow'   => 1,
	'slidesToScroll' => 1,
	'dots'           => false,
	'arrows'         => true,
	'prevArrow'      => sprintf("#%s",  $previous),
	'nextArrow'      => sprintf("#%s",  $next),

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

	$title = get_field('title');

	$rows = get_field('rows');

	
	if( ! empty( $rows ) ) {

		echo '<div class="wrap">';

		printf( '<div class="title-arrows"><h2>%s</h2>%s</div>', $title, $buttons );
		?>
		<div class="values slick" data-slick="<?php echo esc_attr( json_encode( $data_slick ) );?>">
		<?php

		foreach( $rows as $row ) {
			printf( '<div class="value"><div class="value__item"><div class="value__title"><h3 class="h4">%s</h3></div><div class="value__text">%s</div></div></div>', $row['title'], $row['text'] );
		}

		echo '</div><!-- ./values -->';
		
		echo '</div>';
	}


endif;
// close the block
echo $block->after_render();
