<?php
// Generate Press

add_filter( 'option_generate_settings', function( $settings ) {
    $settings['global_colors'] = [
        
        [
            'name' => __( 'Black', 'generatepress' ),
            'slug' => 'black',
            'color' => '#000000',
        ],
        [
            'name' => sprintf( __( 'Grey %s', 'generatepress' ), '1' ),
            'slug' => 'grey-1',
            'color' => '#252B33',
        ],
        [
            'name' => sprintf( __( 'Grey %s', 'generatepress' ), '2' ),
            'slug' => 'grey-2',
            'color' => '#424242',
        ],
        [
            'name' => sprintf( __( 'Grey %s', 'generatepress' ), '3' ),
            'slug' => 'grey-3',
            'color' => '#454C54',
        ],
        [
            'name' => sprintf( __( 'Grey %s', 'generatepress' ), '4' ),
            'slug' => 'grey-4',
            'color' => '#4A4A4A',
        ],        
        [
            'name' => sprintf( __( 'Grey %s', 'generatepress' ), '5' ),
            'slug' => 'grey-5',
            'color' => '#979797',
        ],
        [
            'name' => sprintf( __( 'Grey %s', 'generatepress' ), '6' ),
            'slug' => 'grey-6',
            'color' => '#ececec',
        ],
        [
            'name' => sprintf( __( 'Grey %s', 'generatepress' ), '7' ),
            'slug' => 'grey-7',
            'color' => '#FCF9F9',
        ],
        [
            'name' => __( 'Blue', 'generatepress' ),
            'slug' => 'blue',
            'color' => '#3389B8',
        ],
        [
            'name' => __( 'White', 'generatepress' ),
            'slug' => 'white',
            'color' => '#ffffff',
        ],
       
    ];

    return $settings;
} );

add_filter( 'generateblocks_defaults', function( $defaults ) {
    $color_settings = wp_parse_args(
        get_option( 'generate_settings', array() ),
        generate_get_color_defaults()
    );

    $defaults['button']['backgroundColor'] = $color_settings['form_button_background_color'] ? $color_settings['form_button_background_color'] : '#3389B8';
    $defaults['button']['backgroundColorHover'] = $color_settings['form_button_background_color_hover'] ? $color_settings['form_button_background_color_hover'] : '#000';
    $defaults['button']['textColor'] = '#ffffff';
    $defaults['button']['textColorHover'] = '#ffffff';
    $defaults['button']['paddingTop'] = '12';
    $defaults['button']['paddingRight'] = '20';
    $defaults['button']['paddingBottom'] = '12';
    $defaults['button']['paddingLeft'] = '20';
    $defaults['button']['fontSize'] = '0.8125';
    $defaults['button']['fontSizeUnit'] = 'rem';

    $defaults['button']['textTransform'] = 'uppercase';
    $defaults['button']['letterSpacing'] = '0.06875';
    // $defaults['button']['borderRadiusUnit'] = 'px';
    $defaults['button']['borderRadiusTopRight'] = '24';
    $defaults['button']['borderRadiusBottomRight'] = '24';
    $defaults['button']['borderRadiusBottomLeft'] = '24';
    $defaults['button']['borderRadiusTopLeft'] = '24';
    $defaults['button']['lineHeight'] = '1.53';
    $defaults['button']['lineHeightUnit'] = '';
    
    return $defaults;
} );