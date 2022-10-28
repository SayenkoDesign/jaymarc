import $ from 'jquery';
import InfoBox from './modules/infobox';


        
var $container = $('#acf-map');
        
var map;
var $markers;
var mapZoom = parseInt(map_params.map_zoom)  || 12;
var icon;
var activeMarker = null;
var markersArray = [];
var markersList = [];
var $locationContainer = $('.facetwp-template');
        

// Initialize the map
//google.maps.event.addDomListener(window, 'load', initialize);
initialize();
                

function initialize() {
    
    if($container.length == false) {
        return;   
    }


    console.log(map_params.map_zoom);
    
    var center_lat = $( '.marker[data-active="true"]' ).data('lat');
    var center_lng = $( '.marker[data-active="true"]' ).data('lng');
    map = new google.maps.Map(document.getElementById('acf-map'), {
        center: {lat: center_lat, lng: center_lng},
        mapTypeControl: false,
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        zoom: mapZoom,
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
                    "visibility": "off"
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
    });
    
    loadMarkers(map);
    
    locationTriggerMarker();
    
    // Resize map
    google.maps.event.addDomListener(window, "resize", function() {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
    });	
}
        

function loadMarkers(map) {
    
    var bounds = new google.maps.LatLngBounds();
    
    console.log('markers loaded');
    
    markersArray = [];
    markersArray.infoBoxes = [];
    
    $markers = $('.marker');

    $markers .each(function(index, element) {
        addMarker(index, element, bounds);                
    });  
                
    map.fitBounds(bounds);
    map.panToBounds(bounds)
    
}

function addMarker(index, element, bounds) {
    var number = index + 1;
    var lat = $(element).attr('data-lat');
    var lng = $(element).attr('data-lng');
    var marker_id = $(element).attr('data-id');
    var content = $(element).find('.info-box').html();
    
    var image = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='37' height='52'%3E%3Cdefs%3E%3Cpath id='a' d='M31 89H0V0h62v89H31z'/%3E%3C/defs%3E%3Cg fill='none' fill-rule='evenodd' transform='translate%28-9 -23%29'%3E%3Cmask id='b' fill='%23fff'%3E%3Cuse xlink:href='%23a'/%3E%3C/mask%3E%3Cpath fill='%23000000' d='M45.126 35.944c-.193-.694-.58-1.434-.869-2.083C40.822 25.867 33.313 23 27.25 23 19.134 23 10.195 28.27 9 39.132v2.217c0 .093.032.925.078 1.342.67 5.174 4.89 10.676 8.04 15.853C20.507 64.09 24.024 69.546 27.508 75c2.15-3.56 4.292-7.166 6.39-10.633.574-1.016 1.239-2.031 1.81-3.002.381-.65 1.113-1.295 1.445-1.896C40.542 53.46 46 47.406 46 41.442v-2.45c0-.645-.828-2.91-.874-3.048zM27.234 47.87c-2.463 0-5.158-1.176-6.488-4.427-.199-.518-.183-1.555-.183-1.65v-1.461c0-4.142 3.681-6.028 6.884-6.028 3.94 0 6.99 3.016 6.99 6.784 0 3.769-3.26 6.782-7.203 6.782z' mask='url%28%23b%29'/%3E%3Ccircle cx='28' cy='41' r='11' fill='%23FFF'/%3E%3Ctext fill='%234A4A4A' font-family='sans-serif' font-size='14' font-weight='bold' x='28' y='46' text-anchor='middle'%3E " + number + " %3C/text%3E%3C/g%3E%3C/svg%3E";
    

    var position = new google.maps.LatLng(lat, lng);
    //fit bounds step 2 of 3
    bounds.extend(position);
    
    // https://transformingage.vanwp.ca/wp-content/themes/sayenko-transformingage/assets/images/map-marker.png
    //TO DO: only add markers not alrady theree
    // if its already on the map, dont put it there again
    if (markersList.indexOf(marker_id)) {
        //console.log(marker_id);
       //return;
    } 

                        
    var marker = new google.maps.Marker({
        map: map,
        icon: image,
        _id: marker_id,
        position: new google.maps.LatLng(
            parseFloat(lat),
            parseFloat(lng)
        )
    });
                    
    //fit bounds step 2 of 3
    bounds.extend(marker.position);
    map.fitBounds(bounds);
    map.panToBounds(bounds);
    
    // infobox
    
    var infobox = new InfoBox({
        content: content,
        disableAutoPan: false,
        zIndex: null,
        pixelOffset: new google.maps.Size(-130, -40),
        alignBottom: true,
        boxStyle: {
            //background: "none",
            width: '260px'
        },
        closeBoxMargin: 0
        ,closeBoxURL: map_params.close
        ,infoBoxClearance: new google.maps.Size(1, 1)
        ,isHidden: false
        ,pane: "floatPane"
        ,enableEventPropagation: false
        ,id: marker_id
    });
    
    
    markersArray.push(marker);
    markersList.push(marker_id);
    markersArray.infoBoxes.push(infobox);
    
    
    google.maps.event.addListener(infobox, 'closeclick', function(event) {
        if (activeMarker) {
            icon = activeMarker.getIcon();
            activeMarker.setIcon(icon.replace('3389B8', '000000'));
        }
        
        var $locationList = $('.marker');
        $locationList.removeClass('list-focus');
        
    }); 
    

    google.maps.event.addListener(marker, 'click', function() {
        
        for(var i = 0; i < markersArray.infoBoxes.length; i++){
            markersArray.infoBoxes[i].close();
            icon = markersArray[i].getIcon();
            markersArray[i].setIcon(icon.replace('3389B8', '000000'));
        }
        
        icon = marker.getIcon();
        marker.setIcon(icon.replace('000000', '3389B8'));
        
        
        // center marker on click
        var latLng = marker.getPosition();
        map.setCenter( latLng );
        //map.panBy(0, -150);
                            
        infobox.open( map, marker );
        
        // Locations list
        let $locationList = $markers;
        
        // scroll to marker details
        let $selectedLocation = $('#marker-' + marker_id);

        if ($selectedLocation.length > 0) {

            $locationList.removeClass('list-focus');
            $selectedLocation.addClass('list-focus');

            // Scroll list to selected marker
            $locationContainer.animate({
                scrollTop: $selectedLocation.offset().top - $locationContainer.offset().top + $locationContainer.scrollTop()
            });
        }
        
        
        
        activeMarker = marker;
    });
                    
    google.maps.event.addListener(map, 'click', function(event) {
        if (infobox) {
            infobox.close(); 
        }
        
        if(activeMarker) {
            let icon = activeMarker.getIcon();
            let image = icon.replace('3389B8', '000000');
            activeMarker.setIcon(image);
        }
        
        var $locationList = $('.marker');
        $locationList.removeClass('list-focus');
    });    
}


function locationTriggerMarker() {
    // close info window when map is clicked
    $locationContainer.on( 'click', '.marker', function(event){
                    
        // ignore links
        if(event.target.tagName.toLowerCase() === 'a') {
            return;   
        }
      
        
        // Do nothing if active marker
        if( $(this).hasClass('list-focus') ) {
            return;
        }
                    
        var $locationList = $('.marker');
        var index = $(this).index();
        
        if( 'undefined' !== typeof index ) {
            $locationList.removeClass('list-focus');
            google.maps.event.trigger(markersArray[index], 'click');
            $(this).addClass('list-focus');
        }
        
    });   
}


// TODO: only remove markers that need to be removed. Don't remove all.
// Clear markers
function clearOverlays() {
    for (var i = 0; i < markersArray.length; i++) {
        markersArray[i].setMap(null);
    }
    markersArray = [];
                
}

        
// when we filter, we clear and load new markers
$(document).on('facetwp-loaded', function() {
    clearOverlays();
    loadMarkers(map);
});

// clear State facet
$(document).on('click', '#reset-state', function() {
    if( 'undefined' !== typeof FWP ) {
        FWP.is_reset = true;
        FWP.facets['state'] = []; // set facet to no selections
        delete FWP.facets['paged']; // remove "paged" from URL
        FWP.refresh();
    }            
});

// clear Housing Type facet
$(document).on('click', '#reset-housing_type', function() {
    if( 'undefined' !== typeof FWP ) {
        FWP.is_reset = true;
        FWP.facets['housing_type'] = []; // set facet to no selections
        delete FWP.facets['paged']; // remove "paged" from URL
        FWP.refresh();
    }                
});

// clear Living Options facet
$(document).on('click', '#reset-living_options', function() {
    if( 'undefined' !== typeof FWP ) {
        FWP.is_reset = true;
        FWP.facets['living_options'] = []; // set facet to no selections
        delete FWP.facets['paged']; // remove "paged" from URL
        FWP.refresh();
    }               
});

// show reset facet buttons as needed on page load
$(document).ready(function() {
    
    if( 'undefined' !== typeof FWP_HTTP ) {
        if( FWP_HTTP.get._state ) {
            var $reset_button = $('#reset-state' );
            $reset_button.removeClass( 'hide' );   
        }
        
        if( FWP_HTTP.get._housing_type ) {
            var $reset_button = $('#reset-housing_type' );
            $reset_button.removeClass( 'hide' );   
        }
        
        if( FWP_HTTP.get._living_options ) {
            var $reset_button = $('#reset-living_options' );
            $reset_button.removeClass( 'hide' );   
        }
    }
    
});

// Show/hide individual facet resets as needed
$(document).on('facetwp-loaded', function() {
    
    // while filtering
    $.each(FWP.facets, function(name, vals) {
      
      var facet_name = name;
      // facet in use?
      var in_use = FWP.facets[facet_name].length ? true : false;
      
      var $reset_button = $('#reset-'+ facet_name );
      
      // show clear filters if facets being used
      if(in_use) {
          $reset_button.removeClass( 'hide' );   
      } else {
          $reset_button.addClass( 'hide' );  
      }
                    
      
    });

});
        
        

