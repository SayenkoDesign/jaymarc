<?php
$icon = _s_get_icon(
	[
		'icon'	=> 'filters',
		'group'	=> 'theme',
		'class'	=> 'filter',
		'width' => 28,
		'height' => 21,
		'label'	=> false,
	]
);
?>
<div class="home-filters">
	
	<?php
	// printf( '<div class="acf-button-wrapper"><button class="acf-button reversed" id="filters-toggle">%s%s</button></div>', $icon, __( 'Filters', 'jaymarc' ) );
	?>

	<div class="filters-wrap" aria-expanded="false">

	<div class="filters">


		<?php
		printf('<div class="filter filter--large">%s</div>', facetwp_display('facet', 'status'));
		printf('<div class="filter">%s</div>', facetwp_display('facet', 'area'));
		// printf('<div class="filter">%s</div>', facetwp_display('facet', 'style'));
		
		printf('<div class="filter">%s</div>', facetwp_display('facet', 'price'));
		printf('<div class="filter">%s</div>', facetwp_display('facet', 'sqft'));
		printf('<div class="filter">%s</div>', facetwp_display('facet', 'beds'));
		printf('<div class="filter">%s</div>', facetwp_display('facet', 'baths'));
		?>
		<div class="acf-button-wrapper"><a class="acf-button reversed" href="javascript:;" onclick="FWP.reset()">Clear</a></div>

	</div>

	</div>
	<?php
	printf('<h2>%s</h2>', do_shortcode('[facetwp facet="count"]'));

	echo facetwp_display('selections');
	?>



</div>