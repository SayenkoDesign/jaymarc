<?php
use \App\ACF_Block;

$block = new ACF_Block( $args );

$post_id = get_field( 'post' );

$tabs = get_field( 'tabs', $post_id );

// Open the block
echo $block->before_render();

if( empty( $tabs ) ) :
	get_template_part( sprintf('blocks/%s/%s', $block->get_name(), 'placeholder' ), NULL, [ 'block' => $block ]  );
else :	
	get_template_part( sprintf('blocks/%s/components/%s', $block->get_name(), 'grid' ) );

	get_template_part( sprintf('blocks/%s/components/%s', $block->get_name(), 'slider' ) );

endif;

?>
<script>
(function (document, window, $) {
	
	var <?php echo $block->get_id();?> = $( '#<?php echo $block->get_id();?>');
	
	if ( $('.slick', <?php echo $block->get_id();?>).length ) {
		$('.slick-grid', <?php echo $block->get_id();?>).on('click','.slick-grid__item', function(e){
			var slideIndex = $(this).index();
			$('.slick', <?php echo $block->get_id();?>).slick( 'slickGoTo', parseInt(slideIndex) );
			setTimeout(function() { 
				$('.slick-grid', <?php echo $block->get_id();?>).addClass('is-hidden');
				$('.slick-slider', <?php echo $block->get_id();?>).removeClass('invisible');
			}, 100);
			
		});

		$('.slick-slider .slick-close', <?php echo $block->get_id();?>).on("click", 'a', function(e) {
			e.preventDefault();
			$('.slick-grid', <?php echo $block->get_id();?>).removeClass('is-hidden');
			$('.slick-slider', <?php echo $block->get_id();?>).addClass('invisible');
		});
	}
	
}(document, window, jQuery));

</script>
<?php

// close the block
echo $block->after_render();