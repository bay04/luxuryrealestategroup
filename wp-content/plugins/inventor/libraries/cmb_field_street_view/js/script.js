jQuery(document).ready(function($) {

    $.fn.streetView = function() {
        initializeStreetView(this);
    };

	function initializeStreetView( cmbStreetView ) {
        var streetViewElement = $('body');

        // Input elements
        var latitudeElem = cmbStreetView.find('.street-view-latitude');
        var longitudeElem = cmbStreetView.find('.street-view-longitude');
        var zoomElem = cmbStreetView.find('.street-view-zoom');
        var headingElem = cmbStreetView.find('.street-view-heading');
        var pitchElem = cmbStreetView.find('.street-view-pitch');
        var searchElem = cmbStreetView.find( '.street-view-search' );

        var linksControl = (cmbStreetView.hasClass('cmb2-id-listing-inside-view-location')) ? false : true;

        var latitude = 37.812405;
        var longitude = -122.476078;
        var zoom = 1;
        var heading = -18;
        var pitch = 25;
        var pov;

        if ( latitudeElem.length > 0 && longitudeElem.length > 0 && zoomElem.length > 0 && headingElem.length > 0 && pitchElem.length > 0 ) {

            if ( latitudeElem.val().length > 0 && longitudeElem.val().length > 0 && zoomElem.val().length > 0 && headingElem.val().length > 0 && pitchElem.val().length > 0 ) {
                // If we have saved values
                latitude = latitudeElem.val();
                longitude = longitudeElem.val();
                zoom = Math.round(zoomElem.val()*1000)/1000;
                heading = Math.round(headingElem.val()*1000)/1000;
                pitch = Math.round(pitchElem.val()*1000)/1000;
            } else {
                // Default values
                latitudeElem.val(latitude);
                longitudeElem.val(longitude);
                zoomElem.val(zoom);
                headingElem.val(heading);
                pitchElem.val(pitch);
            }

            // Map init
            var map = new google.maps.Map(cmbStreetView.find('#street-view-map')[0], {
                center: new google.maps.LatLng( latitude, longitude ),
                zoom: 11
            });

            // Street View init
            var streetView = new google.maps.StreetViewPanorama(
                cmbStreetView.find('#street-view')[0], {
                    position: new google.maps.LatLng( latitude, longitude ),
                    zoom: zoom,
                    linksControl: linksControl,
                    pov: {
                        heading: heading,
                        pitch: pitch
                    }
                });
            map.setStreetView(streetView);

            // Insert changes into inputs
            streetViewElement.on('mousemove', function(){
                latitudeElem.val(streetView.getPosition().lat());
                longitudeElem.val(streetView.getPosition().lng());
                zoomElem.val(streetView.getZoom());

                pov = streetView.getPov();
                headingElem.val(pov.heading);
                pitchElem.val(pov.pitch);
            });

            // Search
            var autocomplete = new google.maps.places.Autocomplete( searchElem[0] );
            autocomplete.bindTo( 'bounds', map );

            google.maps.event.addListener( autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                if ( ! place.geometry ) {
                    return;
                }

                if ( place.geometry.viewport ) {
                    map.fitBounds( place.geometry.viewport );
                } else {
                    map.setCenter( place.geometry.location );
                    map.setZoom( 17 );
                }

                streetView.setPosition( new google.maps.LatLng( place.geometry.location.lat(), place.geometry.location.lng()));

                map.setStreetView(streetView);

                latitudeElem.val( place.geometry.location.lat() );
                longitudeElem.val( place.geometry.location.lng() );
            });

            $( searchElem ).keypress( function( event ) {
                if ( 13 === event.keyCode ) {
                    event.preventDefault();
                }
            });
        }
	}

});
