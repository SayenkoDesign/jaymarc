<?php
$block = $args['block'];

$block->add_render_attribute(
	'block', 'class', [
	   'acf-block-placeholder',
		]
	);

// Open the block
echo $block->before_render();
?>
<div class="acf-block-placeholder__title"><?php echo $block->get_title();?></div>
	<div class="acf-block-placeholder__instructions">Click to Edit</div>
<?php
// close the block
echo $block->after_render();