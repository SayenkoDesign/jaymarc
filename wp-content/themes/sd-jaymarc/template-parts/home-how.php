<?php
$open_house = _s_get_icon(
	[
		'icon'	=> 'open-house',
		'group'	=> 'theme',
		'width' => 62,
		'height' => 49,
		'label'	=> false,
	]
);

$appointment = _s_get_icon(
	[
		'icon'	=> 'private-appointment',
		'group'	=> 'theme',
		'width' => 64,
		'height' => 56,
		'label'	=> false,
	]
);
?>
<div class="how-to-tour">
	<h2>Tour Model Homes</h2>

	<div class="grid">
		<div class="open-house">
			<div class="content">
				<div class="icon"><?php echo $open_house; ?></div>
				<h3>Open House</h3>
				<?php
				the_field('open_house', 'home_archive');
				?>
			</div>
		</div>

		<span class="h2 or">OR</span>

		<div class="private-appointment">
			<div class="content">
				<div class="icon"><?php echo $appointment; ?></div>
				<h3>Private Appointment</h3>
				<?php
				the_field('private_appointment', 'home_archive');

				$button = _s_acf_button([
					'link' => get_field('private_appointment_link', 'home_archive'),
					'classes' => 'acf-button acf-button-more-arrow',
					'echo' => false
				]);

				if (!empty($button)) {
					printf('<div class="acf-button-wrapper">%s</div>', $button);
				}

				$emails = get_field('emails', 'home_archive');

				if( ! empty( $emails ) ) {
					echo '<div class="emails">';
					$emails = preg_split("/\r\n|\n|\r/", $emails );
					foreach( $emails as $email ) {
						printf( '<p><a href="mailto:%1$s">%1$s</a></p>', $email );
					}
					echo '</div>';
				}
				?>
			</div>
		</div>

	</div>

</div>