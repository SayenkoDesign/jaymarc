<?php

/**
 * The template for displaying Archive pages.
 *
 * @package GeneratePress
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_filter('generate_show_post_navigation', '__return_false');


// Filter the marker array (can be used to add custom values)
add_filter('facetwp_map_marker_args', function ($args, $post_id) {

    $title      = _s_format_string(get_the_title($post_id), 'h3', ['class' => 'title']);

    $address = get_home_address($post_id);

    $area = _s_get_primary_term('area', $post_id );
    if( ! empty( $area ) ) {
        $area = sprintf( '<h4>%s</h4>', $area->name );
    }

    $learn_more = sprintf(
        '<div class="acf-button-wrapper"><a class="acf-button blue reversed" href="%s">%s</a></div>',
        get_permalink($post_id),
        __('View Details')
    );


    $directions = '';
    if (!empty($location['lat'])) {
        $directions = sprintf(
            '<span class="directions"><a href="https://www.google.com/maps/dir/?api=1&destination=%s,%s" target="_blank">%s [+]</a></span>',
            $location['lat'],
            $location['lng'],
            __('Get Directions')
        );
    }


    $content = sprintf(
        '<div class="info-box">
                <div class="info-box-top"></div>
                <div class="info-box-middle">%s%s%s</div>
                <div class="info-box-bottom"></div>
                </div>',
        $title,
        $area,
        $learn_more
    );

    $args['content'] = $content;

    return $args;
}, 10, 2);


get_header(); ?>

<div <?php generate_do_attr('content'); ?>>
	<main <?php generate_do_attr('main'); ?>>
		<?php
		/**
		 * generate_before_main_content hook.
		 *
		 * @since 0.1
		 */
		do_action('generate_before_main_content');

		/**
		 * generate_archive_title hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_archive_title - 10
		 */
		do_action('generate_archive_title');

		get_template_part('template-parts/portfolio', 'filters');

		echo '<div class="locations">';

		echo '<div class="locations-wrap">';

		echo '<div class="facetwp-template">';

		if (generate_has_default_loop()) {

			if (have_posts()) :



				/**
				 * generate_before_loop hook.
				 *
				 * @since 3.1.0
				 */
				do_action('generate_before_loop', 'archive');




				while (have_posts()) :

					the_post();

					get_template_part('content', 'portfolios');

				endwhile;


				/**
				 * generate_after_loop hook.
				 *
				 * @since 2.3
				 */
				do_action('generate_after_loop', 'archive');

			else :

				//generate_do_template_part('none');

				echo '<p>No results found.</p>';

			endif;
		}

		echo '</div>';

		echo facetwp_display('facet', 'pager_');

		echo '</div>';

		echo '<div class="map">';

		echo facetwp_display('facet', 'map');

		echo '</div>';

		echo '</div>';


		/**
		 * generate_after_main_content hook.
		 *
		 * @since 0.1
		 */
		do_action('generate_after_main_content');
		?>
	</main>
</div>

<?php
/**
 * generate_after_primary_content_area hook.
 *
 * @since 2.0
 */
do_action('generate_after_primary_content_area');

generate_construct_sidebars();

get_footer();
