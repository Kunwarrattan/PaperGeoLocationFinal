/**
 * Created by india on 3/8/2015.
 */
var address;
var map;
var geocoder;
//var bounds = new google.maps.LatLngBounds();
var markersArray = [];
var longi;
var latti;

function initialize() {
    var opts = {
        center: new google.maps.LatLng(55.53, 9.4),
        mapTypeId:google.maps.MapTypeId.ROADMAP,
        rotateControl: true,
        streetViewControl: true,
        overviewMapControl: true,
        zoom: 4
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), opts);
    geocoder = new google.maps.Geocoder();
}

function adddresSetup(addressCall){
    address = addressCall;
    getLatLong(address);
}

function getLatLong(address) {

    geocoder = new google.maps.Geocoder();
    var result = "";
    geocoder.geocode( { 'address': address }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
                    var addr_type = results[0].formatted_address;
                    longi = results[0].geometry.location.lng();
                    latti = results[0].geometry.location.lat();
                    var v = address+" "+longi+" "+ latti+" "+addr_type +"";
                    alert(v);
                    document.getElementById('map-canvas').innerHTML=v;
        } else {
            result = "Unable to find address: " + status;
        }
       // storeResult(result);
    });
}