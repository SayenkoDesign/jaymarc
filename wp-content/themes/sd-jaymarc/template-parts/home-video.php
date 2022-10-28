
<?php
$thumbnail = get_field('video_thumbnail');
$url       = get_field('video');

if( empty( $url ) ) {
	return false;
}

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
<div class="video-wrapper">
	<a href="<?php echo $link;?>" class="pulse" data-fancybox><span><?php echo $icon;?></span></a>
	<div class="overlay"></div>
	<?php
	echo wp_get_attachment_image( $thumbnail, 'large' );
	?>
</div>
