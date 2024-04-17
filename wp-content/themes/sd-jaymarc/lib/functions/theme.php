<?php
function number_to_word($number) {
    $wordMap = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine'
    );

    // Check if the number is in the wordMap
    if (isset($wordMap[$number])) {
        return $wordMap[$number];
    } else {
        return "Number out of range";
    }
}

add_filter('generate_svg_icon', function ($output, $icon) {
	if ('menu-bars' === $icon) {
		$output = '<svg aria-hidden="true" role="img" xmlns="http://www.w3.org/2000/svg" width="38" height="26" stroke="#3389b8" fill="none" stroke-linecap="square" stroke-width="3" xmlns:v="https://vecta.io/nano"><path d="M2 12h34M2 22.5h27M2 2h27"/></svg>
		<svg aria-hidden="true" role="img" xmlns="http://www.w3.org/2000/svg" width="25" height="25" xmlns:v="https://vecta.io/nano"><path d="M14.441 12.294l9.645-9.645a1.48 1.48 0 0 0 0-2.146 1.48 1.48 0 0 0-2.143 0l-9.649 9.649L2.649.503c-.613-.61-1.532-.61-2.146 0s-.61 1.533 0 2.146l9.649 9.645-9.649 9.649a1.48 1.48 0 0 0 0 2.143 1.48 1.48 0 0 0 2.146 0l9.645-9.645 9.649 9.645c.613.613 1.529.613 2.143 0s.613-1.529 0-2.143l-9.645-9.649z" fill="#3389b8" fill-rule="evenodd"/></svg>';

		$classes = array(
			'gp-icon',
			'icon-' . $icon,
		);

		return sprintf(
			'<span class="%1$s">%2$s</span>',
			implode(' ', $classes),
			$output
		);
	}

	return $output;
}, 15, 2);



add_action('generate_before_header_content', function () {

	$icon = _s_get_icon(
		[
			'icon'	=> 'phone',
			'group'	=> 'theme',
			'class'	=> 'phone-icon',
			'width' => 32,
			'height' => 28,
			'label'	=> false,
		]
	);
	printf('<div class="mobile-phone"><a href="tel:%s">%s<span class="screen-reader-text">Phone</span></a></div>', '12345678', $icon);
}, 0);




add_image_size('wide', '2000', '9999');

add_filter('image_size_names_choose', function ($default_sizes) {
	return array_merge($default_sizes, array(
		'wide' => __('Wide'),
	));
});



function display_year()
{
	$year = date('Y');
	return $year;
}
add_shortcode('year', 'display_year');


add_action('wp_footer', 'add_modals_to_footer');
function add_modals_to_footer()
{

	$args = array(
		'post_type'      => 'modal',
		'posts_per_page' => 100,
		'post_status'    => 'publish'
	);

	$loop = new WP_Query($args);

	if ($loop->have_posts()) :
		while ($loop->have_posts()) : $loop->the_post();
			$slug = sanitize_title_with_dashes(get_the_title());
?>
			<div class="modal" id="<?php echo $slug; ?>" style="display: none;">
				<div class="modal-wrap">
					<div class="modal-content">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
<?php
		endwhile;
	endif;

	wp_reset_postdata();
}



/**
 * Splits an array into N number of evenly distributed partitions (useful for
 * splitting a list into columns).
 *
 * The function will fill as many partitions as requested, as long as there are
 * enough elements in the array to do so.  Any remaining unfilled partitions
 * will be represented as empty arrays.
 *
 * It can be sent an array of any data types or objects.
 *
 * @since 1.1
 *
 * @param array $array Array of items to be evenly distributed into columns.
 * @param int $number_of_columns Number of columns to split the items contained in $array into.
 * @return array An array whose elements are sub-arrays representing columns containing the distributed items from $array.
 */
function c2c_array_partition($array, $number_of_columns)
{
	$number_of_columns = (int) $number_of_columns;
	$arraylen = count($array);
	$partlen = floor($arraylen / $number_of_columns);
	$partrem = $arraylen % $number_of_columns;
	$partition = array();
	$mark = 0;
	for ($px = 0; $px < $number_of_columns; $px++) {
		$incr = ($px < $partrem) ? $partlen + 1 : $partlen;
		$partition[$px] = array_slice($array, $mark, $incr);
		$mark += $incr;
	}
	return $partition;
}



// return lines as list items
if (!function_exists('nl2li')) {
	function nl2li($string)
	{
		return '<li>' . implode('</li><li>', explode("\n", $string)) . '</li>';
	}
}
