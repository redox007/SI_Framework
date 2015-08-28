<script type="text/javascript">

    function initialize() {
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();


        navigator.geolocation.getCurrentPosition(function (pos) {

            center = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
            var myOptions = {
                zoom: 13,
                center: center,
                mapTypeControl: false,
                panControl: false,
                zoomControl: false,
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById('map-canvas'), myOptions);

            directionsDisplay.setMap(map);
            directionsDisplay.setOptions({
                draggable: true
            });

            directionsDisplay.setPanel(document.getElementById('direction-panel'));

            bind_google_autocomplete('pickup-addr', on_pickup_address_change, retriction);
            bind_google_autocomplete('drop-addr', on_drop_address_change, retriction);

            places = new google.maps.places.PlacesService(map);
            stepDisplay = new google.maps.InfoWindow();

            google.maps.event.addListener(directionsDisplay, 'directions_changed', function () {
                computeTotalDistance(directionsDisplay.getDirections());
            });

        }, function (e) {
            logme('Error', e);
        });

        var p_lat = $('input[name="booking[pickup_lat]"]').val();
        var p_long = $('input[name="booking[pickup_long]"]').val();

        var d_lat = $('input[name="booking[drop_lat]"]').val();
        var d_long = $('input[name="booking[drop_long]"]').val();

        if (p_lat != '' && p_long != '' && d_lat != '' && d_long != '') {

            _pick_up = create_map_marker(new google.maps.LatLng(p_lat, p_long));
            _drop = create_map_marker(new google.maps.LatLng(d_lat, d_long));

            show_route_paths();
        }

    }
    function on_pickup_address_change(element_id, auto_object, place) {
        if (place.geometry) {
            if (_pick_up)
                _pick_up.setMap(null);
            _pick_up = create_map_marker(place.geometry.location);
            map.panTo(place.geometry.location);
            _marker_array.push(_pick_up);
            show_route_paths();
        }
    }
    function on_drop_address_change(element_id, auto_object, place) {
        if (place.geometry) {
            if (_drop)
                _drop.setMap(null);
            _drop = create_map_marker(place.geometry.location);
            map.panTo(place.geometry.location);
            _marker_array.push(_drop);
            show_route_paths();
        }
    }
    function show_route_paths(route_path) {
        logme(route);
        if (route_path) {

            route = route_path;
            calcRoute();
            return false;
        }
        if (_pick_up) {
            route.origin = _pick_up.getPosition();
        }
        if (_drop) {
            route.destination = _drop.getPosition();
        }
        if (route.origin && route.destination) {
            calcRoute(route);
        }
    }
    function calcRoute(route) {

//     First, remove any existing markers from the map.
        _marker_array = reset_pointers(_marker_array);

        // Route the directions and pass the response to a
        // function to create markers for each step.
        directionsService.route(route, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
//                var warnings = document.getElementById('warnings_panel');
//                warnings.innerHTML = '<b>' + response.routes[0].warnings + '</b>';
                directionsDisplay.setDirections(response);
                logme('Direction response ', response);
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    $(function () {
        $('.multidate_picker').datepicker({
            multidate: true,
            format: 'yyyy-mm-dd'
        });
        $('body').on('click', '#uniform-is_flexi', function (e) {
            $('#timeframe').toggleClass('hideme');
            $('#timepicker').toggleClass('hideme');
        });


    });
</script>