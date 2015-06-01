var milliseconds = 10;

var index = 5;

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

function codeLatLng(lat1,long1) {
   // var input = document.getElementById('latlng').value;
   // var latlngStr = input.split(',', 2);
    var lat = parseFloat(lat1);
    var lng = parseFloat(long1);


    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var addr_type = results[0].formatted_address;
          // longi = results[0].geometry.location.lng();
           // latti = results[0].geometry.location.lat();
            var city1 = null;
            var state1 = null;
            var coutry1 = null;
            var v;
            //cit = results[0].geometry.location.lat();
            //prov = results[0].geometry.location.lat();
            //cntry = results[0].geometry.location.lat();

            console.log(lat+" , "+lng);

            if (results[0]) {
                //formatted address
                // alert(results[0].formatted_address)
                //find country name
                for (var i=0; i<results[0].address_components.length; i++) {
                    for (var b=0;b<results[0].address_components[i].types.length;b++) {

                        //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                        if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                            //this is the object you are looking for
                            state1 = results[0].address_components[i];
                          //  alert(state1);
                            // alert(city1);
                            break;
                        }
                        if (results[0].address_components[i].types[b] == "locality") {
                            //this is the object you are looking for
                            city1 = results[0].address_components[i];
                         //     alert(state1);
                            break;
                        }
                        if (results[0].address_components[i].types[b] == "country") {
                            //this is the object you are looking for
                            coutry1 = results[0].address_components[i];
                         //   alert(coutry1);
                            break;
                        }
                    }
                }
                //city data
                // alert(city1.short_name + " ... " + city1.long_name);
                //  alert(state1.short_name+ " ... " + state1.long_name);
                //  alert(coutry1.short_name+ " ... " + coutry1.long_name);
                var ki = latlng + " || " +city1.long_name+"||"+state1.long_name+"||"+coutry1.long_name;
                var kis = city1.short_name+"||"+state1.short_name+"||"+coutry1.short_name;
                console.log(ki);
                console.log(kis);
                //v = city1.long_name+"||"+state1.long_name+"||"+coutry1.long_name;
                ////longi+"||"+ latti+"||"+
                ////alert(v);
                //console.log(v);
            } else {
                console.log("No results found");
            }

           // insertlatLongIntoDB(v);
            // alert(v);
        } else {
            console.log('Geocoder failed due to: ' + status);
        }
    });
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
           // alert(data.length);
            for(i=0;i<data.length;i++) {
                temp_html= data[i].count+" , "+data[i].lat+" , "+data[i].long+ "<br />";
               // alert(temp_html);
                adddresSetup(data[i].count,data[i].lat,data[i].long);
            }
            //adddresSetup(11,41.2772797,-7.477030199999945);
            //alert(data.length);
            var temp = "-------------------------------------------<br/>";
            $('#data-list').append(temp_html);
          //  $('#data-list').append(temp);

        }
    }
        ajaxRequest.open("GET", "getdata.php?index="+index , true);
        ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajaxRequest.setRequestHeader("Accept-Language", "en-US");
        ajaxRequest.send();
        sleep();


}

function adddresSetup(i,lat,long){
    //startTimer();
    address = i+","+lat+","+long;
    //alert(address);
    //sleep();
    codeLatLng(lat,long);
}

