var geocoder;
//var map;
var infowindow = new google.maps.InfoWindow();
//var marker;
var index=1;
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

function codeLatLng(id,lat,long) {
    var count = id;
    var latitude = lat;
    var longitude = long;
    //var input = document.getElementById('latlng').value;
    //var latlngStr = input.split(',', 2);
    var lat = parseFloat(latitude);
    var lng = parseFloat(longitude);
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {

                var city="";
                var region="";
                var country="";

                var result = results[1].formatted_address;
                document.getElementById("map-canvas").innerHTML = result;

                for (var i=0; i<results[1].address_components.length; i++)
                {
                    if (results[1].address_components[i].types[0] == "locality") {
                        city = results[1].address_components[i];
                //        alert("city = "+city.long_name);
                    }
                    if (results[1].address_components[i].types[0] == "administrative_area_level_1") {
                        region = results[1].address_components[i];
                        //alert("state ="+ region.long_name);
                    }


                    if (results[1].address_components[i].types[0] == "country") {
                        country = results[1].address_components[i];
                    //    alert("country = "+country.long_name);
                    }
                }

                var address = count+" ||||| "+result+" ---- "+city.long_name+ " " +region.long_name+ " " + country.long_name;
                alert(address);
                update(count,result,city.long_name,region.long_name,country.long_name);
            } else {
                alert('No results found');
            }
        } else {
            alert('Geocoder failed due to: ' + status);
        }
    });
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

function getData(){
    ajaxCall();
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var val = ajaxRequest.responseText;
            var data = JSON.parse(val);
            var temp_html = "";
            console.log(data);
            console.log("-------------------------------------------------------------------");
            for(var i=0;i<data.length;i++) {
                temp_html= data[i].count+" , "+data[i].lat+" , "+data[i].long+ "<br />";
                adddresSetup(data[i].count,data[i].lat,data[i].long);
            }
            var temp = "-------------------------------------------<br/>";
        }
    }
    ajaxRequest.open("GET", "getData.php?index="+index , true);
    ajaxRequest.send();
   // sleep();

}


function adddresSetup(id,lat,long){
    address = id+","+lat+","+long;
    codeLatLng(id,lat,long);
}


function update(id, address, city,state,country){
    ajaxCall();
   //alert(id);
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var val = ajaxRequest.responseText;
//            alert(val);
            //var data = JSON.parse(val);
            //var temp_html = "";
           // var div = document.getElementById('map-canvas');
           // div.innerHTML = div.innerHTML + data;
            //console.log(data);

            //console.log("-------------------------------------------------------------------");
            //for(var i=0;i<data.length;i++) {
                //temp_html= data[i].count+" , "+data[i].lat+" , "+data[i].long+ "<br />";
                //adddresSetup(data[i].count,data[i].lat,data[i].long);
            //}
           // var temp = "-------------------------------------------<br/>";
        }
    }
    ajaxRequest.open("GET", "update.php?id="+id+"&address="+address+"&city="+city+"&state="+state+"&country="+country , true);
    ajaxRequest.send();
}