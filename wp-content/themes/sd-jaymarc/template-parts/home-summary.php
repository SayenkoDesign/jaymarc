<?php
$group = get_field('summary');


if( empty( $group ) ) {
	return false;
}

$title   = $group['title'] ?? '';
$colums_per_row = $group['columns_per_row'] ?? '1';

$grid_columns = number_to_word($colums_per_row);

$columns = $group['columns'] ?? '';

?>
<div class="summary">
	<?php
	echo _s_format_string( $title, 'h2' );

	if(! empty($columns)) :
		
	?>
	<div class="grid grid--<?php echo $grid_columns;?>">
		<?php
		foreach( $columns as $column ) {
			?>
			<div class="grid__column">
				<?php 
				echo $column['content'];
				?>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	endif;
	?>
	
</div>


