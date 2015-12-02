var map;
var geocoder;
var bounds = new google.maps.LatLngBounds();
var markersArray = [];
var index = 1;
var origin1 = new google.maps.LatLng(55.930, -3.118);
var destinationB = new google.maps.LatLng(50.087, 14.421);

function initialize() {
    var opts = {};
    map = new google.maps.Map(document.getElementById('map-canvas'), opts);
    geocoder = new google.maps.Geocoder();
}



var milliseconds = 1001;

function sleep() {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}

function sleep(val) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > val){
            break;
        }
    }
}


function calculateDistances(id,lat1,lng1,lat2,lng2) {
    var origin = new google.maps.LatLng(lat1, lng1);
    var destination = new google.maps.LatLng(lat2, lng2);
	//console.log(id + "-------------------------------------------------------------------");
	sleep(3000);
	//console.log("-------------------------------------------------------------------");
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
        {
            origins: [origin],
            destinations: [destination],
            travelMode: google.maps.TravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
        }, function(response, status) {callback(response, status, id)});
}

function callback(response, status,id) {
	//console.log("Callback="+id);
    if (status != google.maps.DistanceMatrixStatus.OK) {
        alert('Error was: ' + status);
    } else {
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;
		//console.log("origins = "+origins);
		//console.log("destinations="+destinations);
		for (var i = 0; i < origins.length; i++) {
            var results = response.rows[i].elements;
			console.log("Results="+results.length);
            for (var j = 0; j < results.length; j++) {
                outputDiv.innerHTML += origins + '------ to ------' + destinations + '<br/> ' + results[j].distance.text + ' in ' + results[j].duration.text +" ID= "+id+"<br/><br/>";
				console.log("Index ="+index+" .. ID =  "+id+"  .... "+results[j].distance.value+"  .... "+results[j].duration.value);
                updateToDatabase(id,results[j].distance.value,results[j].duration.value);
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
    //alert("a");
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var val = ajaxRequest.responseText;
            var data = JSON.parse(val);
			//console.log("-------------------------------------------------------------------");
            console.log(data.length);
			//console.log("-------------------------------------------------------------------");
            var i;
            var temp_html = "";
            console.log(data);
			//
		    
			sleep(6000);
            console.log("-------------------------------------------------------------------");
			
            for(i=0;i<data.length;i++) {
                temp_html += data[i].count+" - "+data[i].lat1+" - "+data[i].lng1+" - "+data[i].lat2+" - "+data[i].lng2+"<br/>";
              //  alert(data[i].lat1+" ..... "+data[i].lng1+" ..... "+data[i].lat2+" ..... "+data[i].lng2);
				console.log(data[i].count+" .. "+data[i].lat1+" .. "+data[i].lng1+" .. "+data[i].lat2+" .. "+data[i].lng2);
                calculateDistances(data[i].count,data[i].lat1,data[i].lng1,data[i].lat2,data[i].lng2);
            }
            //var temp = "-------------------------------------------<br/>";
            //$('#map-canvas').append(temp_html);
            //$('#map-canvas').append(temp);

        }
    }
    ajaxRequest.open("GET", "getData.php?index="+index , true);
    ajaxRequest.send();
}
function randomIntFromInterval(min,max)
{
    return Math.floor(Math.random()*(max-min+1)+min);
}


function updateToDatabase(id,distance11,time){
	console.log("id="+id);
	sleep(1111);	
    distance = distance11/1000;//.slice(0, -2);
    time =  toHHMMSS(time);
    ajaxCall();
    var str = id+"  "+distance+"  " +time;
	console.log(str);
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
			index++;
            var val = ajaxRequest.responseText;
            // var data = JSON.parse(val);
            // console.log(data.length);
            // var i;
            // var temp_html = "";
			
            console.log(val);
            //console.log("-------------------------------------------------------------------");

           // var temp = "-------------------------------------------<br/>";
	       sleep(10000);
           ajaxFunction();
        }
    }
    ajaxRequest.open("GET", "update.php?distance="+distance+"&time="+time+"&id="+id, true);
    ajaxRequest.send();
}

function toHHMMSS(time) {
    var sec_num = parseInt(time, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    var time1    = hours+':'+minutes+':'+seconds;
    return time1;
}