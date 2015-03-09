/**
 * Created by india on 3/8/2015.
 */

    function ajaxFunction(){
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
                    adddresSetup(str_array[i]);
                }
            }
        }
        ajaxRequest.open("GET", "insert.php" , true);
        ajaxRequest.send();
    }
