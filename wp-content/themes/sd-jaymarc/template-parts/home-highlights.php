<?php
$rows = get_field('highlights');

if( empty( $rows ) ) {
	return false;
}
?>
<div class="highlights">
	<h2 class="border-top-center">Home Highlights</h2>
	<div class="highlights__box">
		<?php
		foreach( $rows as $row ) {
			?>
			<div class="highlight">
						<?php 
						$icon = _s_get_icon(
							[
								'icon'	=> 'checkmark',
								'group'	=> 'theme',
								'class'	=> 'checkmark',
								'width' => 18,
								'height' => 15,
								'label'	=> false,
							]
						);
						printf( '<div><span class="icon">%s</span>%s</div>', $icon, $row['text'] ); 
						?>
					</div>
			<?php
		}
		?>
	</div>
	
</div>


