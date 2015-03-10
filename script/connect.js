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
                    var v = longi+"||"+ latti+"||"+addr_type+"||"+address;
                    insertlatLongIntoDB(v);
                    //alert(v);
                    document.getElementById('map-canvas').innerHTML=v;
        } else {
            result = "Unable to find address: " + status;
        }
       // storeResult(result);
    });
}


function insertlatLongIntoDB(stringVal){
    var ajaxRequest;  // The variable that makes Ajax possible!

    try{
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    }catch (e){
        // Internet Explorer Browsers
        try{
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }catch (e) {
            try{
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }catch (e){
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var val = ajaxRequest.responseText;
            var str_array = val.split('||');

            for(var i = 0; i < str_array.length; i++) {
                 //alert(str_array[i]);
            }
        }
    }

    var k = [];
    k = stringVal.split("||");
   // alert(k[0]);
    ajaxRequest.open("GET", "insertLLIntoDB.php?lat="+k[0]+"&lng="+k[1]+"&addressnew="+k[2]+"&addressold="+k[3] , true);
    ajaxRequest.send();
}