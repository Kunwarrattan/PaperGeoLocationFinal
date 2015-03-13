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
var ajaxRequest;
var milliseconds = 1001;
var index = 18;
function sleep() {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}

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

function adddresSetup(i,inst,vil,pro,con){
    //startTimer();
    address = inst+","+vil+","+pro+","+con;
    sleep();
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
                   // alert(v);
        } else {
            result = "Unable to find address: " + status;
        }
    });
}


function ajaxFunction(){
    ajaxCall();
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var val = ajaxRequest.responseText;
            var data = JSON.parse(val);
            //console.log(data.length);
            var i;
            var temp_html = "";
            console.log(data);
            for(i=0;i<data.length;i++) {
                temp_html += data[i].count+" - "+data[i].institute+" - "+data[i].ville+" - "+data[i].province+" - "+data[i].country+"<br/>";
                adddresSetup(data[i].count,data[i].institute, data[i].ville, data[i].province, data[i].country);
            }
            $('#data-list').append(temp_html);

        }
    }
    ajaxRequest.open("GET", "insert.php?index="+index , true);
    ajaxRequest.send();
}

function randomIntFromInterval(min,max)
{
    return Math.floor(Math.random()*(max-min+1)+min);
}

function insertlatLongIntoDB(stringVal){
    ajaxCall();
   // alert(stringVal);
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            index++;
            //sleep();
            var k =randomIntFromInterval(1000,2000);
            setTimeout(ajaxFunction(),  k);
            var val = ajaxRequest.responseText;
            var str_array = val.split('||');
            for(var i = 0; i < str_array.length; i++) {
                 //alert(str_array[i]);
            }
        }
    }
    var k = [];
    k = stringVal.split("||");
   // alert(k[0]+" "+k[1]+" "+k[2]+" "+k[3]);
    //alert("insertLLIntoDB.php?lat="+k[0]+"&lng="+k[1]+"&addressnew="+k[2]+"&addressold="+k[3]);
    ajaxRequest.open("POST", "insertLLIntoDB.php?lat="+k[0]+"&lng="+k[1]+"&addressnew="+k[2]+"&addressold="+k[3], true);
    ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajaxRequest.send(null);
}