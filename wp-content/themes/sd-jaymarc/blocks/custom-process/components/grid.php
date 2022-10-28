<?php
$post_id = get_field( 'post' );
// Tabs

if( have_rows('tabs', $post_id ) ): 

$rows = count( get_field( 'tabs', $post_id ) );

$remainder = $rows % 4;
$items = ( $remainder < 1 ) ? 4 : 3; 
?>

	<div class="slick-grid flex-grid-items-<?php echo $items;?>">

	<?php while( have_rows('tabs', $post_id ) ) : the_row(); ?>
		<div class="slick-grid__item">
			<div class="icon">
				<?php
				$svg = get_sub_field( 'icon');
				$file = wp_get_attachment_image_src(get_sub_field( 'icon', false ));
				$filetype = wp_check_filetype( $file[0] );

				if( ! empty( $svg ) && 'svg' == $filetype['ext']  ) {
					$icon = file_get_contents( get_attached_file( $svg ) ); 
					printf( '<span>%s</span>',  $icon );
					$reversed = str_replace( [ '#3389b8', '#979797' ], [ '#ffffff', '#ffffff' ], $icon );
					printf( '<span>%s</span>',  $reversed );
				} else {
					echo wp_get_attachment_image( get_sub_field('icon'), 'medium' );
				}
				?>
			</div>
			<div class="content">
				<h3 class="h4"><?php echo get_row_index(); ?>. <?php the_sub_field('title');?></h3>
				<p><?php the_sub_field('subtitle');?></p>
			</div>
		</div>

	<?php endwhile; ?>

	</div>

	

<?php endif;