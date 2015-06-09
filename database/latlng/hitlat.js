var geocoder;
//var map;
var infowindow = new google.maps.InfoWindow();
//var marker;
function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(40.730885,-73.997383);
    var mapOptions = {
        zoom: 8,
        center: latlng,
        mapTypeId: 'roadmap'
    }
    //map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

function codeLatLng() {
    var input = document.getElementById('latlng').value;
    var latlngStr = input.split(',', 2);
    var lat = parseFloat(latlngStr[0]);
    var lng = parseFloat(latlngStr[1]);
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {

                var city=NULL;
                var region=NULL;
                var country=NULL;

                var result = results[1].formatted_address;
                document.getElementById("map-canvas").innerHTML = result;

                for (var i=0; i<results[1].address_components.length; i++)
                {
                    if (results[1].address_components[i].types[0] == "locality") {
                        city = results[1].address_components[i];
                        alert("city = "+city.long_name);
                    }
                    if (results[1].address_components[i].types[0] == "administrative_area_level_2") {
                        region = results[1].address_components[i];
                        alert("state2 ="+ region.long_name);
                    }
                    if (results[1].address_components[i].types[0] == "administrative_area_level_1") {
                        region = results[1].address_components[i];
                        alert("state ="+ region.long_name);
                    }
                    if (results[1].address_components[i].types[0] == "country") {
                        country = results[1].address_components[i];
                        alert("country = "+country.long_name);
                    }
                }
            } else {
                alert('No results found');
            }
        } else {
            alert('Geocoder failed due to: ' + status);
        }
    });
}

google.maps.event.addDomListener(window, 'load', initialize);


function getData(){

}