<?php

$url = get_field( 'url' );

if( empty( $url ) ) {
	return;
}

use \App\ACF_Block;

$block = new ACF_Block( $args );

$block->set_html_tag( 'span' );

// Open the block
echo $block->before_render();

$link = add_query_arg( array(
	'autoplay' => 1,
	'modestbranding' => 1,
	'rel' => 0
), $url );

$icon = _s_get_icon(
	[
		'icon'	=> 'video-play-icon',
		'group'	=> 'theme',
		'class'	=> 'video-play-icon',
		'width' => 76,
		'height'=> 76,
		'label'	=> false,
	]
);

?>
<a href="<?php echo $link;?>" class="pulse" data-fancybox><?php echo $icon;?></a>
<?php

// close the block
echo $block->after_render();