
var geocoder, location1, location2, gDir;

function initialize() {
    geocoder = new GClientGeocoder();
    gDir = new GDirections();
    GEvent.addListener(gDir, "load", function() {
        var drivingDistanceMiles = gDir.getDistance().meters / 1609.344;
        var drivingDistanceKilometers = gDir.getDistance().meters / 1000;
        document.getElementById('results').innerHTML = '<strong>Address 1: </strong>' + location1.address + ' (' + location1.lat + ':' + location1.lon + ')<br /><strong>Address 2: </strong>' + location2.address + ' (' + location2.lat + ':' + location2.lon + ')<br /><strong>Driving Distance: </strong>' + drivingDistanceMiles + ' miles (or ' + drivingDistanceKilometers + ' kilometers)';
    });
}

function showLocation() {
    geocoder.getLocations(document.forms[0].address1.value, function (response) {
        if (!response || response.Status.code != 200)
        {
            alert("Sorry, we were unable to geocode the first address");
        }
        else
        {
            location1 = {lat: response.Placemark[0].Point.coordinates[1], lon: response.Placemark[0].Point.coordinates[0], address: response.Placemark[0].address};
            geocoder.getLocations(document.forms[0].address2.value, function (response) {
                if (!response || response.Status.code != 200)
                {
                    alert("Sorry, we were unable to geocode the second address");
                }
                else
                {
                    location2 = {lat: response.Placemark[0].Point.coordinates[1], lon: response.Placemark[0].Point.coordinates[0], address: response.Placemark[0].address};
                    gDir.load('from: ' + location1.address + ' to: ' + location2.address);
                }
            });
        }
    });
}
