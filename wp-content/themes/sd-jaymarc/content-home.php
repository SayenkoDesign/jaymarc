<?php
/**
 * The template for displaying single posts.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('grid-container'); ?> <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article">

		<header class="entry-title">
			<div>
			<?php
			$title = get_the_title();
			if( ! empty( _s_get_primary_term( 'home_type' ) ) ) {
				$title = _s_get_primary_term( 'home_type' )->name;
			}
			printf( '<div class="h1">%s</div>', $title );

			$floor_plan = get_field( 'floor_plan' );
			if( ! empty( $floor_plan ) ) {
				printf( '<div class="h3">Plan: <a href="%s">%s</a></div>', get_permalink( $floor_plan ), get_the_title( $floor_plan ) );
			}
			?>
			</div>
			<div>
			<?php
			get_template_part( 'template-parts/home', 'share' );
			?>
			</div>
			
		</header>

		<?php
		get_template_part( 'template-parts/home', 'gallery' );
		?>
	
		<section class="details">
			
			<div class="grid">
				<div class="grid__column grid__column--left">
					
					<?php
					$price = sprintf( '$%s', number_format( get_field('price') ) );
					$hide_price_message = get_field('hide_price_message');
					if( ! empty( $hide_price_message ) ) {
						$price = $hide_price_message;
					}

					$location = get_field('location');
					?>
					<ul class="price-address">
						<li class="price"><?php echo $price;?></li>
						<li class="address"><h1><?php the_title();?>, <span><?php echo $location['city'];?>, <?php echo $location['state_short'];?> <?php echo $location['post_code'];?></span></h1></li>
					</ul>

					<?php
					$sqft = sprintf( '%s', number_format( get_field('square_feet') ) );
					$beds = get_field('beds');
					$baths = get_field('baths');
					$car_garages = get_field('car_garages'); // optional
					$stories = get_field('stories'); // optional
					$style = _s_get_primary_term('style');
					?>

					<ul class="specs">
						<li class="sqft"><?php echo $sqft;?><span>Sq. Ft.</span></li>
						<li class="beds"><?php echo $beds;?><span>Beds</span></li>
						<li class="baths"><?php echo $baths;?><span>Baths</span></li>
						<?php if( ! empty( $car_garages ) ):?>
						<li class="car-garages"><?php echo $car_garages;?><span>Car Garages</span></li>
						<?php endif;?>
						<?php if( ! empty( $stories ) ):?>
						<li class="stories"><?php echo $stories;?><span>Stories</span></li>
						<?php endif;?>
						<?php if( ! empty( $style ) ):?>
						<li class="style"><?php echo $style->name;?><span>Style</span></li>
						<?php endif;?>
					</ul>
				</div>

				<div class="grid__column grid__column--right">
					<div class="acf-button-wrapper stacked">
						<?php
						echo _s_acf_button( [
							'link' => get_field('get_started', 'option'),
							'classes' => 'acf-button',
						] );
						?>

						<?php
						$download = get_field('download_packet');
						if( ! empty( $download ) ) :
						?>
						<a href="<?php echo $download;?>" class="acf-button reversed" download>Download Packet</a>
						<?php
						endif;

						$email_icon = _s_get_icon(
							[
								'icon'	=> 'email',
								'group'	=> 'theme',
								'class'	=> 'email',
								'width' => 38,
								'height' => 22,
								'label'	=> false,
							]
						);
						
	
						$email_subject = get_field('email_subject', 'option');
						$email_body = get_field('email_body', 'option');
						printf( '<a href="mailto:?body=%s&subject=%s" class="email-this" target="_blank"><span class="icon">%s</span> Email This</a>', $email_body, $email_subject, $email_icon );
						?>
						
					</div>
					
				</div>

			</div>

		</section>

		<?php
		get_template_part( 'template-parts/home', 'highlights' );

		get_template_part( 'template-parts/home', 'floorplans' );
		?>
		
	</div>
</article>
