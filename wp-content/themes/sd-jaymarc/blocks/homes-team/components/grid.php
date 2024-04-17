<?php
$post_ids = get_field('posts');

$args = array(
	'post_type' => 'team',
	'order' => 'ASC',
	'orderby' => 'menu_order',
	'posts_per_page' => -1,
	'fields' => 'ids'
);


if (!empty($post_ids)) {
	$args['orderby'] = 'post__in';
	$args['post__in'] = $post_ids;
	$args['posts_per_page'] = count($post_ids);
}

if( empty( $post_ids ) ) {
	return;
}

// Use $loop, a custom variable we made up, so it doesn't overwrite anything
$loop = new WP_Query($args);

// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
// don't want to use $wp_query, use our custom variable instead.
if ($loop->have_posts()) :
?>	
	<div class="<?php echo ($loop->post_count > 1 ) ? 'grid' : '';?>">
		<?php
		while ($loop->have_posts()) : $loop->the_post();

		?>
			<div class="grid__item">
				<div class="grid__thumbnail">
				
						<?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?>
				
				</div>
				<div class="grid__text">
					<h3><?php echo get_the_title(get_the_ID()); ?></h3>
					<?php
					$phone = get_field('phone', get_the_ID());
					if( ! empty( $phone ) ) {
						$phone_icon = _s_get_icon(
							[
								'icon'	=> 'phone',
								'group'	=> 'theme',
								'class'	=> 'email',
								'width' => 34,
								'height' => 29,
								'label'	=> false,
							]
						);

						$tel = preg_replace('/\D/', '', $phone);

						printf( '<p><a href="tel:%s" target="_blank" aria-label="phone number"><span>%s</span><span> %s</span></a></p>', $tel, $phone_icon, $phone  );
					}

					$email = get_field('email', get_the_ID());
					if( ! empty( $email ) ) {
						$email_icon = _s_get_icon(
							[
								'icon'	=> 'email-alt',
								'group'	=> 'theme',
								'class'	=> 'email',
								'width' => 27,
								'height' => 27,
								'label'	=> false,
							]
						);

						printf( '<p><a href="mailto:%s" target="_blank" aria-label="email address"><span>%s</span><span> %s</span></a></p>', $email, $email_icon, $email  );
					}

					
					?>
				</div>
			</div>
		<?php

		endwhile;
		?>
	</div>
<?php
endif;
wp_reset_postdata();
