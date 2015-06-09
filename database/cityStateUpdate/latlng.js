/**
 * Created by india on 6/8/2015.
 */
var milliseconds = 10;
var index = 5;

function sleep() {
    var start = new Date().getTime();
    for (var r = 0; r < 1e7; r++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}

function sleep(val) {
    var start = new Date().getTime();
    for (var r = 0; r < 1e7; r++) {
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
function ajaxFunction(){
    ajaxCall();
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var val = ajaxRequest.responseText;
            var data = JSON.parse(val);
            var r;
            var temp_html = "";
            console.log(data);
            console.log("-------------------------------------------------------------------");
            alert(data.length);
            for(r=0;r<data.length;r++) {
                temp_html= data[r].count+" , "+data[r].lat+" , "+data[r].long+ "<br />";
       //         adddresSetup(data[r].count,data[r].lat,data[r].long);
            }
            var temp = "-------------------------------------------<br/>";
            $('#data-list').append(temp_html);
        }
    }
    ajaxRequest.open("GET", "getdata.php?index="+index , true);
    ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajaxRequest.setRequestHeader("Accept-Language", "en-US");
    ajaxRequest.send();
    sleep();


}

function adddresSetup(r,lat,long){
    address = r+","+lat+","+long;
    //codeLatLng(r,lat,long);
}