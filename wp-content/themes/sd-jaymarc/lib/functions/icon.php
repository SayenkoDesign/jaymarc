<?php

/**
 * Get Icon
 * This function is in charge of displaying SVG icons across the site.
 *
 * Place each <svg> source in the /assets/icons/{group}/ directory, without adding
 * both `width` and `height` attributes, since these are added dynamically,
 * before rendering the SVG code.
 *
 *
 */
function _s_get_icon( $atts = array() ) {

	$atts = shortcode_atts( array(
		'icon'	=> false,
		'group'	=> 'utility',
        'class' => 'svg-icon',
		'width'	=> 16,
        'height' => 16,
        'role' => 'img',
        'aria-hidden' => 'true',
        'focusable' => 'false'
	), $atts );

	if( empty( $atts['icon'] ) )
		return;

	$icon_path = get_theme_file_path( '/assets/icons/' . $atts['group'] . '/' . $atts['icon'] . '.svg' );

	if( ! file_exists( $icon_path ) )
		return;

		
    
    // remove icon and group 
    unset( $atts['icon'], $atts['group'] );

    $icon = file_get_contents( $icon_path );
    
    $attr = _parse_icon_attribute( $atts );
    
    $svg  = preg_replace( '/^<svg /', '<svg ' . $attr . ' ', trim( $icon ) ); // Add extra attributes to SVG code.
        
    $svg  = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
    $svg  = preg_replace( '/>\s*</', '><', $svg ); // Remove white space between SVG tags.

    return $svg;
}


function _parse_icon_attribute( $attr ) {
	if( is_array( $attr ) ) {
		$t = [];
		foreach( $attr as $k => $v ) {
			if( ! empty( $v ) ) {
                $out = sprintf('%s="%s"', $k, esc_attr( $v ) );
                $t[] = $out;
			}
		}
		return implode( ' ', $t );
	}
	else {
		return $attr;	
	}
}
