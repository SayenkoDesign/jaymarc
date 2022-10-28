<?php
// Post



add_action( 'wp', 'tu_remove_featured_images', 99 );
function tu_remove_featured_images() {
	if( ! is_singular('post') ) {
		return;
	}
	
	// remove_action( 'generate_before_content', 'generate_featured_page_header_inside_single', 99 );
	add_action( 'generate_after_entry_header', 'generate_featured_page_header_inside_single', 10 );
}

add_shortcode('mv_post_reading_time', 'show_reading_time' );

function show_reading_time() {
    global $post;

	$read = reading_time($post->post_content);

	if ($read) {

		$minutes = ceil($read / 60);

		$read_icon = _s_get_icon(
			[
				'icon'	=> 'clock',
				'group'	=> 'theme',
				'width'	=> '24',
				'height' => '24',
				'class'	=> 'read-time',
				'label'	=> false,
			]
		);

		return sprintf('<div class="read">%s<span> %d %s</span></div>', $read_icon, $minutes, __('min Read', 'microvision'));
	}
}

/**
 * READING TIME
 *
 * Calculate an approximate reading-time for a post.
 *
 * @param  string $content The content to be measured.
 * @return  integer Reading-time in seconds.
 */
function reading_time($content)
{

	// Predefined words-per-minute rate.
	$words_per_minute = 225;
	$words_per_second = $words_per_minute / 60;

	// Count the words in the content.
	$word_count = str_word_count(strip_tags($content));

	// [UNUSED] How many minutes?
	$minutes = floor($word_count / $words_per_minute);

	// [UNUSED] How many seconds (remainder)?
	$seconds_remainder = floor($word_count % $words_per_minute / $words_per_second);

	// How many seconds (total)?
	$seconds_total = floor($word_count / $words_per_second);

	return $seconds_total;
}


