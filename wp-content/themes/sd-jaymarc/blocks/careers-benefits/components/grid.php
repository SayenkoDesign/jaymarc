<?php
$post_id = get_field( 'post' );
// Tabs

if( have_rows('tabs', $post_id ) ): ?>

	<div class="slick-grid">

	<?php while( have_rows('tabs', $post_id ) ) : the_row(); ?>
		<div class="slick-grid__item">
		<?php echo wp_get_attachment_image( get_sub_field('icon'), 'medium' ); ?>
		<h3><?php the_sub_field('title');?></h3>
		</div>

	<?php endwhile; ?>

	</div>

	

<?php endif;