<?php
// Team

function team_contact_info() {
	$email = get_field('email');
	$linkedin = get_field('linkedin');
	$phone = get_field('phone');

	$out = '';


	if( ! empty( $linkedin ) ) {
		$linkedin_icon = _s_get_icon(
			[
				'icon'	=> 'linkedin-brands',
				'group'	=> 'social',
				'class'	=> 'linkedin',
				'width' => 15,
				'height' => 15,
				'label'	=> false,
			]
		);

		$out .= sprintf( '<li class="linkedin"><a href="%s" target="_blank"><span class="icon">%s</span><span class="screen-reader-text">Email</span></a></li>', $linkedin, $linkedin_icon  );
	}


	if( ! empty( $email ) ) {
		$email_icon = _s_get_icon(
			[
				'icon'	=> 'email',
				'group'	=> 'social',
				'class'	=> 'email',
				'width' => 15,
				'height' => 15,
				'label'	=> false,
			]
		);

		$out .= sprintf( '<li class="email"><a href="email:%s" target="_blank"><span class="icon">%s</span><span class="screen-reader-text">Email</span></a></li>', $email, $email_icon  );
	}

	

	if( ! empty( $phone ) ) {
		$phone_icon = _s_get_icon(
			[
				'icon'	=> 'phone',
				'group'	=> 'theme',
				'class'	=> 'phone',
				'width' => 32,
				'height' => 28,
				'label'	=> false,
			]
		);

		$out .= sprintf( '<li class="phone"><a href="tel:%s" target="_blank"><span class="icon">%s</span><span class="screen-reader-text">Phone</span></a></li>', $phone, $phone_icon  );
	}

	if( ! empty( $out ) ) {
		return sprintf( '<ul class="team-contact-info">%s</uL>', $out );
	}
}

function team_home_specs() {

	$style 		= _s_get_primary_term('style');
	$home_type 	= _s_get_primary_term('home_type');
	$area 		= _s_get_primary_term('area');

	$out = '';

	if( ! empty( $style ) ) {
		$out .= sprintf( '<li class="style"><span>Style: </span>%s</li>', $style->name );
	}

	if( ! empty( $home_type ) ) {
		$out .= sprintf( '<li class="status"><span>Status: </span>%s</li>', $home_type->name );
	}

	if( ! empty( $area ) ) {
		$out .= sprintf( '<li class="area"><span>Location: </span>%s</li>', $area->name );
	}

	if( ! empty( $out ) ) {
		return sprintf( '<ul class="specs">%s</ul>', $out );
	}
}