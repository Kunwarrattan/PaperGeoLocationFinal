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

var index = 1;

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
    inst.replace(/ /g , "+");
    vil.replace(/ /g , "+");
    pro.replace(/ /g , "+");
    con.replace(/ /g , "+");

    address = inst+","+vil+","+pro+","+con;
    sleep();
    getLatLong(address,i,true);
}

function getLatLong(address,id,flag) {
    if(flag == false){
        console.log(address);
        console.log("Inverse action");
		sleep(500);
    }
    var add = address;
    geocoder = new google.maps.Geocoder();
    var result = "";
    geocoder.geocode( { 'address': address }, function(results, status) {
        //alert(status);
        console.log(status);
        if (status == google.maps.GeocoderStatus.OK) {
                    var addr_type = results[0].formatted_address;
                    longi = results[0].geometry.location.lng();
                    latti = results[0].geometry.location.lat();
                    var city1 = null;
                    var state1 = null;
                    var coutry1 = null;
                    var v;
                    //cit = results[0].geometry.location.lat();
                    //prov = results[0].geometry.location.lat();
                    //cntry = results[0].geometry.location.lat();



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
                                       // alert(city1);
                                        break;
                                    }
                                    if (results[0].address_components[i].types[b] == "locality") {
                                        //this is the object you are looking for
                                        city1 = results[0].address_components[i];
                                     //   alert(state1);
                                        break;
                                    }
                                    if (results[0].address_components[i].types[b] == "country") {
                                        //this is the object you are looking for
                                        coutry1 = results[0].address_components[i];
                                       // alert(coutry1);
                                        break;
                                    }
                                }
                            }
                            //city data
                           // alert(city1.short_name + " ... " + city1.long_name);
                          //  alert(state1.short_name+ " ... " + state1.long_name);
                          //  alert(coutry1.short_name+ " ... " + coutry1.long_name);
                            var ki = city1.long_name+"||"+state1.long_name+"||"+coutry1.long_name;
                            var kis = city1.short_name+"||"+state1.short_name+"||"+coutry1.short_name;
                            console.log(ki);
                            console.log(kis);
                            v = longi+"||"+ latti+"||"+addr_type+"||"+address+"||"+id+"||"+city1.long_name+"||"+state1.long_name+"||"+coutry1.long_name;
                            //alert(v);
                            console.log(v);
                        } else {
                            alert("No results found");
                        }

                    insertlatLongIntoDB(v);
                   // alert(v);
        } 
		else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
            //console.log(address);
            var str_array = address.split(",");
            var ints = str_array[0];
            var ville = str_array[1];
            var province = str_array[2];
            var country = str_array[3];


            ints.replace(/ /g , "+");
            ville.replace(/ /g , "+");
            province.replace(/ /g , "+");
            country.replace(/ /g , "+");
            var add = null;

            if(ville==""){
                add = province+","+country;
            }
            else if(province==""){
                add = ville+","+country;
            }
            else if(country==""){
                add = ville+","+province;
            }else{
				add = country;
			}
            console.log("ignored address="+add+" id =" + id);
            getLatLong(add,id,false);
        }
		else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
			sleep(5000);
		}
    });
}


function ajaxFunction(){

    alert("a");
    ajaxCall();
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var val = ajaxRequest.responseText;
            var data = JSON.parse(val);
            //console.log(data.length);
            var i;
            var temp_html = "";
            console.log(data);
            console.log("-------------------------------------------------------------------");
            for(i=0;i<data.length;i++) {
                temp_html += data[i].count+" - "+data[i].institute+" - "+data[i].ville+" - "+data[i].province+" - "+data[i].country+"<br/>";
                adddresSetup(data[i].count,data[i].institute, data[i].ville, data[i].province, data[i].country);
            }
            var temp = "-------------------------------------------<br/>";
            $('#data-list').append(temp_html);
            $('#data-list').append(temp);

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
            var k =randomIntFromInterval(500,2000);
            setTimeout(ajaxFunction(),  k);
            var val = ajaxRequest.responseText;
          //  alert(val);
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
    ajaxRequest.open("POST", "insertLLIntoDB.php?lat="+k[0]+"&lng="+k[1]+"&addressnew="+k[2]+"&addressold="+k[3]+"&id="+k[4] +"&cty="+k[5]+"&state="+k[6]+"&country="+k[7], true);
    ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Accept-Language", "en-US");
    ajaxRequest.send(null);
}