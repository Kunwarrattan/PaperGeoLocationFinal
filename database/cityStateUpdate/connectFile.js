/**
 * Created by india on 5/19/2015.
 */
/**
 * Created by india on 3/8/2015.
 */
//alert("aa");


var address;
var map;
var geocoder;
//var bounds = new google.maps.LatLngBounds();
var markersArray = [];
var longi;
var latti;
var ajaxRequest;

var index = 1;

function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(40.730885,-73.997383);
    var mapOptions = {
        zoom: 8,
        center: latlng,
        mapTypeId: 'roadmap'
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

google.maps.event.addDomListener(window, 'load', initialize);

function ajaxCall(){
    try{
        ajaxRequest = new XMLHttpRequest();
    }catch (e){
        try{
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }catch (e) {
            try{
                ajaxRequests = new ActiveXObject("Microsoft.XMLHTTP");
            }catch (e){
                alert("Your browser broke!");
                return false;
            }
        }
    }
}

function ajaxFunction(){
    ajaxCall();

    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var val = ajaxRequest.responseText;
            //alert(val);
            var data = JSON.parse(val);
            //console.log(data.length);
            var i;
            var temp_html = "";
            console.log(data);
            console.log("-------------------------------------------------------------------");
            for(i=0;i<data.length;i++) {
                temp_html+= data[i].count+" , "+data[i].lat+" , "+data[i].long+ "<br />";
              //  alert(temp_html);
                adddresSetup(data[i].count,data[i].lat,data[i].long);
            }
            //alert(data.length);
            var temp = "-------------------------------------------<br/>";
            $('#data-list').append(temp_html);
            $('#data-list').append(temp);

        }
    }
    ajaxRequest.open("GET", "getdata.php?index="+index , true);
    ajaxRequest.send();
}

function adddresSetup(i,lat,long){
    //startTimer();
    address = i+","+lat+","+long;
    alert(address);
    codeLatLng(lat,long);
}
//function getLatLong(address,lat,long,id,flag) {



function codeLatLng(lat,lng) {
    //geocoder = new google.maps.Geocoder();
    //var latlng = new google.maps.LatLng(lat,lng);
    var input = document.getElementById('latlng').value;
    var latlngStr = input.split(',', 2);
    var lat = parseFloat(latlngStr[0]);
    var lng = parseFloat(latlngStr[1]);
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                map.setZoom(11);
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
                infowindow.setContent(results[1].formatted_address);
                alert(results[1].formatted_address);
                infowindow.open(map, marker);
            } else {
                alert('No results found');
            }
        } else {
            alert('Geocoder failed due to: ' + status);
        }
    });
}
