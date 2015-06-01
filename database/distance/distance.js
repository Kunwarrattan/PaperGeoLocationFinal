var map;
var geocoder;
var bounds = new google.maps.LatLngBounds();
var markersArray = [];

var origin1 = new google.maps.LatLng(55.930, -3.118);
var destinationB = new google.maps.LatLng(50.087, 14.421);

function initialize() {
    var opts = {};
    map = new google.maps.Map(document.getElementById('map-canvas'), opts);
    geocoder = new google.maps.Geocoder();
}

function calculateDistances() {
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
        {
            origins: [origin1],
            destinations: [destinationB],
            travelMode: google.maps.TravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
        }, callback);
}

function callback(response, status) {
    if (status != google.maps.DistanceMatrixStatus.OK) {
        alert('Error was: ' + status);
    } else {
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;
        //   var outputDiv = document.getElementById('outputDiv');
        //   outputDiv.innerHTML = '';
        deleteOverlays();

        for (var i = 0; i < origins.length; i++) {
            var results = response.rows[i].elements;
            //  addMarker(origins[i], false);
            for (var j = 0; j < results.length; j++) {
                //    addMarker(destinations[j], true);
                outputDiv.innerHTML += origin1 + '<br/> to <br/>' + destinationB
                + '<br/> ' + results[j].distance.text + ' in '
                + results[j].duration.text + '<br>';
            }
        }
    }
}



function deleteOverlays() {
    for (var i = 0; i < markersArray.length; i++) {
        markersArray[i].setMap(null);
    }
    markersArray = [];
}

google.maps.event.addDomListener(window, 'load', initialize);