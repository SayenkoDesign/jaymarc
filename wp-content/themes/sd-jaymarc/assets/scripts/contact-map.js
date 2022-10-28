import $ from 'jquery';

function initialise() {
	var myLatlng = new google.maps.LatLng(map_params.lat, map_params.lng); // Add the coordinates
	var mapOptions = {
		zoom: parseInt(map_params.map_zoom), // The initial zoom level when your map loads (0-20)
		//minZoom: 6, // Minimum zoom level allowed (0-20)
		//maxZoom: 17, // Maximum soom level allowed (0-20)
		zoomControl:true, // Set to true if using zoomControlOptions below, or false to remove all zoom controls.
		zoomControlOptions: {
			  style:google.maps.ZoomControlStyle.DEFAULT // Change to SMALL to force just the + and - buttons.
		},
		center: myLatlng, // Centre the Map to our coordinates variable
		mapTypeId: google.maps.MapTypeId.ROADMAP, // Set the type of Map
		scrollwheel: false, // Disable Mouse Scroll zooming (Essential for responsive sites!)
		// All of the below are set to true by default, so simply remove if set to true:
		panControl:false, // Set to false to disable
		mapTypeControl:false, // Disable Map/Satellite switch
		scaleControl:false, // Set to false to hide scale
		streetViewControl:false, // Set to disable to hide street view
		overviewMapControl:false, // Set to false to remove overview control
		rotateControl:false, // Set to false to disable rotate control
		fullscreenControl: false,
		styles: [
			{
				"featureType": "administrative",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "administrative.country",
				"elementType": "geometry.stroke",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "administrative.province",
				"elementType": "geometry.stroke",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "landscape",
				"elementType": "geometry",
				"stylers": [
					{
						"visibility": "on"
					},
					{
						"color": "#e3e3e3"
					}
				]
			},
			{
				"featureType": "landscape.natural",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "poi",
				"elementType": "all",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "road",
				"elementType": "all",
				"stylers": [
					{
						"color": "#cccccc"
					}
				]
			},
			{
				"featureType": "road",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "on"
					}
				]
			},
			{
				"featureType": "transit",
				"elementType": "labels.icon",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "transit.line",
				"elementType": "geometry",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "transit.line",
				"elementType": "labels.text",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "transit.station.airport",
				"elementType": "geometry",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "transit.station.airport",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			},
			{
				"featureType": "water",
				"elementType": "geometry",
				"stylers": [
					{
						"color": "#FFFFFF"
					}
				]
			},
			{
				"featureType": "water",
				"elementType": "labels",
				"stylers": [
					{
						"visibility": "off"
					}
				]
			}
		]
	  }
	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions); // Render our map within the empty div
	var image = new google.maps.MarkerImage("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='34' height='48' xmlns:v='https://vecta.io/nano'%3E%3Cpath d='M32.286 11.947c-.171-.64-.518-1.323-.774-1.92C28.44 2.645 21.729 0 16.31 0 9.056 0 1.067 4.864 0 14.89v2.048c0 .085.029.853.071 1.238.598 4.778 4.368 9.856 7.184 14.635L16.543 48l5.71-9.813c.511-.939 1.105-1.878 1.617-2.774.341-.597.993-1.194 1.291-1.749 3.029-5.546 7.905-11.136 7.905-16.64v-2.261c0-.597-.74-2.687-.781-2.816zM16.443 22.23c-2.132 0-4.466-1.066-5.618-4.011-.172-.469-.158-1.408-.158-1.494v-1.323c0-3.754 3.187-5.461 5.96-5.461 3.414 0 6.054 2.731 6.054 6.145s-2.824 6.144-6.238 6.144z' fill='%233389b8'/%3E%3C/svg%3E", null, null, null, new google.maps.Size(34,48)); // Create a variable for our marker image.
	var marker = new google.maps.Marker({ // Set the marker
		position: myLatlng, // Position marker to coordinates
		icon:image, //use our image as the marker
		map: map, // assign the market to our map variable
		title: 'Click here for directions.' // Marker ALT Text
	});

	map.panBy(72, -60);
	 	
	/* var infowindow = new google.maps.InfoWindow({ // Create a new InfoWindow
		  content:"This is <strong>Megamall Penang</strong>, <em>one</em> of shopping centres that has a cinema!" // HTML contents of the InfoWindow
	  });
	google.maps.event.addListener(marker, 'click', function() { // Add a Click Listener to our marker
		  infowindow.open(map,marker); // Open our InfoWindow
	  }); */
	google.maps.event.addDomListener(window, 'resize', function() { 
		//map.setCenter(myLatlng); 
		//map.panBy(95, -40)
	}); // Keeps the Pin Central when resizing the browser on responsive sites
}
google.maps.event.addDomListener(window, 'load', initialise); // Execute our 'initialise' function once the page has loaded.