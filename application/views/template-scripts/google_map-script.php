<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?php __e(GOOGLE_MAP_API_KEY); ?>"></script>
<script type="text/javascript">

    var MARKER_PATH = 'https://maps.gstatic.com/intl/en_us/mapfiles/marker_green';
    var retriction = {componentRestrictions: {'country': 'in'}};
    var directionsDisplay,
            directionsService,
            stepDisplay,
            places,
            map;

    var _pick_up, _drop;
    var _marker_array = [];
    var route = {};
    route.travelMode = google.maps.TravelMode.DRIVING;
    route.optimizeWaypoints = true;

    function get_last_element(array) {
        return (array.length > 0) ? array[array.length - 1] : false;
    }
    function delete_last_element(array) {
        array.splice((array.length - 1), 1);
        return array;
    }
    function reset_pointers(pointers) {
        if (pointers) {
            for (var i = 0; i < pointers.length; i++) {
                pointers[i].setMap(null);
            }
        }
        return [];
    }
    function bind_google_autocomplete(id, change_function, retriction) {
        var auto_object = new google.maps.places.Autocomplete(document.getElementById(id), retriction);
        google.maps.event.addListener(
                auto_object,
                'place_changed',
                function () {
                    var place = auto_object.getPlace();
                    change_function(id, auto_object, place);
                    $('#' + id).parent().find('input.lat').val(place.geometry.location.lat());
                    $('#' + id).parent().find('input.long').val(place.geometry.location.lng());
                });
    }
    function create_map_marker(location) {
        var marker = new google.maps.Marker({
            map: map,
            draggable: false
        });
        marker.setPosition(location);
        return marker;
    }
</script>