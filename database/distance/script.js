var map;
var geocoder;
var bounds = new google.maps.LatLngBounds();
var markersArray = [];
var longi;
var latti;

// ------------------------------------------------------------------------------------------------------
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

//------------------------------------------------------------------------------------------------------
function calculateDistances() {
    dest1 = "montreal";
    dest2 = "toronto";
    cal(dest1,dest2);
}

function cal(dest1,dest2){

    origin1=dest1;
    destinationA=dest2;


    var service = new google.maps.DistanceMatrixService();

    service.getDistanceMatrix(
        {
            origins: [origin1],
            destinations: [destinationA],
            travelMode: google.maps.TravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
        }, callback);
}

//--------------------------------------------------------------------------------------------------------
function callback(response, status) {
    if (status != google.maps.DistanceMatrixStatus.OK) {
        alert('Error was: ' + status);
    } else {
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;
        var outputDiv = document.getElementById('outputDiv');
        outputDiv.innerHTML = '';
        var data1;
        deleteOverlays();
        for (var i = origins.length-1; i >= 0; i--) {
            var results = response.rows[i].elements;
            addMarker(origins[i], false);
            data1 = origins[i];
            data1 = data1.split(",").splice(-1);
            var k=i;
            for (var j = 0; j < results.length; j++) {
//    					if(destinations[i]==origins[i]){
//    							stringValue = "Source = "+ destinations[i];
//    					}


                var data = destinations[j]; //destination

                data=data.split(",").splice(-1);

                var stringValue = "Citing Location : "+ origins[i] + " : " + destinations[j] + ": Cited From :" + results[j].duration.text + ":"+ results[j].distance.text;

                addMarker(destinations[j], true, stringValue);

                // alert(data+" "+data1);

                // outputDiv.innerHTML += origins[i] + ' to ' + destinations[j]
                // + ':== ' + results[j].distance.text + ' in :== '
                // + results[j].duration.text + '<br>';
            }
        }
    }
}
var jj=0;
//--------------------------------------------------------------------------------------------------------
function addMarker(location, isDestination, String) {
    var iconBase;

    if (isDestination) {
        iconBase = 'https://maps.google.com/mapfiles/kml/shapes/schools_maps.png';
    } else {
        iconBase =  'https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png';
    }

    geocoder.geocode({'address': location}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (!isDestination) {
                longi = results[0].geometry.location.lng();
                latti = results[0].geometry.location.lat();
            } else {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
            }

            if(latitude!=null && longitude!=null && longi!=null && latti!=null){

                var difference = distance(latitude,longitude,latti,longi,'K');
                difference = Number((difference).toFixed(2));
                var timeCal = timeCa(difference);

                var data = [];
                var timec = Number((timeCal).toFixed(2)).toString();;
                data = timec.split(".");

                //spliting string having origin,destination,duration,distance

                var k = [];
                k = String.split(":");

                StringVal = String + " Travel Distance = " + difference + " Kms and Time Taken = " + data[0]+ " HH : " +data[1]+" MM";


                var table = document.getElementById("myTable");

                var row = table.insertRow(0);
                var cell9 = row.insertCell(0);
                cell9.className = 'tabelStyle';

                document.getElementById('myTable').rows[0].cells[0].colSpan =4;
                document.getElementById('myTable').rows[0].id="k";
                document.getElementById('k').style.color= "#a23111";


                var row = table.insertRow(1);
                var cell11 = row.insertCell(0);
                var cell12 = row.insertCell(1);
                document.getElementById('myTable').rows[1].cells[0].colSpan =2
                document.getElementById('myTable').rows[1].cells[1].colSpan =2
                document.getElementById('myTable').rows[1].id="kka";
                document.getElementById('kka').style="background-color:#aa1100;	border-width: 11px; font-size: 10px;";


                var row = table.insertRow(2);
                var cell4 = row.insertCell(0);
                var cell5 = row.insertCell(1);
                var cell6 = row.insertCell(2);
                var cell7 = row.insertCell(3);
                cell11.className = 'table1';
                cell12.className = 'table2';

                document.getElementById('myTable').rows[2].id="kk";
                document.getElementById('kk').style="font-style:normal;  font-size: 12px;  background-color: #001122;"

                cell11.innerHTML = "Citing : "+k[1];
                cell12.innerHTML = "Cited : "+k[2];
                cell4.innerHTML = "Flying Distance "+" : "+ difference;
                cell5.innerHTML = "Flying Time" +" : "+ data[0]+ " HH : " +data[1]+" MM";
                cell6.innerHTML = "Driving Distance "+" : "+ k[5];
                cell7.innerHTML = "Driving Time" +" : "+ k[4];
            }
            jj++;

            var dest=new google.maps.LatLng(latitude,longitude);
            var origin=new google.maps.LatLng(latti,longi);
            var distLine = [origin,dest];

            var flightPath=new google.maps.Polyline({
                path:distLine,
                strokeColor:"#663399",
                strokeOpacity:0.8,
                strokeWeight:2
            });

            if(!latitude==0){
                flightPath.setMap(map);
            }

            bounds.extend(results[0].geometry.location);

            map.fitBounds( bounds);

            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
                draggable: true,
                raiseOnDrag: true,
                labelContent: latitude,
                labelAnchor: new google.maps.Point(13, 130),
                labelClass: "labels", // the CSS class for the label
                icon: iconBase,
                labelInBackground: true
            });
            var iw = new google.maps.InfoWindow({
                content: String
            });
            google.maps.event.addListener(marker, "click", function (e) { iw.open(map, this); });
            markersArray.push(marker);
        } else {
            alert('Geocode was not successful for the following reason: '
            + status);
        }
    });
}


function deleteOverlays() {
    for (var i = 0; i < markersArray.length; i++) {
        markersArray[i].setMap(null);
    }
    markersArray = [];
}

google.maps.event.addDomListener(window, 'load', initialize);



function distance(lat1, lon1, lat2, lon2, unit) {
    var radlat1 = Math.PI * lat1/180;
    var radlat2 = Math.PI * lat2/180;
    var radlon1 = Math.PI * lon1/180;
    var radlon2 = Math.PI * lon2/180;
    var theta = lon1-lon2;
    var radtheta = Math.PI * theta/180;
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    dist = Math.acos(dist);
    dist = dist * 180/Math.PI;
    dist = dist * 60 * 1.1515;
    if (unit=="K") { dist = dist * 1.609344; }
    if (unit=="N") { dist = dist * 0.8684; }
    return dist;
}

function timeCa(distance){
    var speed = 885; //747 Jumbo Jet assumption http://hypertextbook.com/facts/2002/JobyJosekutty.shtml

    var time = distance/speed;

    return time;
}/**
 *
 */