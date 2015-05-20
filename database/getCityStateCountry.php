<html>
<head></head>
<body>
<form>

</form>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/19/2015
 * Time: 7:31 PM
 */

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
require 'database.php';



    $query2 = 'SELECT `id`,`lat`,`long` FROM `final_addresses2` where `city` = "" and `province` = "" and `country` = "" LIMIT 10,15 ';
   // echo $query2;
    $result2 = mysqli_query($link, $query2);
    //echo $result2->num_rows."<br/>";
    if($result2->num_rows>0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            $id = $row['id'];
            $latitude = $row['lat'];
            $longitude = $row['long'];
            $geolocation = $latitude.','.$longitude;
            echo "<br/>".$geolocation;
            $request = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=false';
            echo $request;
            $file_contents = file_get_contents($request);
            $json_decode = json_decode($file_contents);
            if(isset($json_decode->results[0])) {
                $response = array();
                foreach($json_decode->results[0]->address_components as $addressComponet) {
                    if(in_array('political', $addressComponet->types)) {
                        $response[] = $addressComponet->long_name;
                    }
                }

                if(isset($response[0])){ $first  =  $response[0];  } else { $first  = 'null'; }
                if(isset($response[1])){ $second =  $response[1];  } else { $second = 'null'; }
                if(isset($response[2])){ $third  =  $response[2];  } else { $third  = 'null'; }
                if(isset($response[3])){ $fourth =  $response[3];  } else { $fourth = 'null'; }
                if(isset($response[4])){ $fifth  =  $response[4];  } else { $fifth  = 'null'; }

                if( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth != 'null' ) {
                    echo "<br/>Address:: ".$first;
                    echo "<br/>City:: ".$second;
                    echo "<br/>State:: ".$fourth;
                    echo "<br/>Country:: ".$fifth;
                }
                else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth == 'null'  ) {
                    echo "<br/>Address:: ".$first;
                    echo "<br/>City:: ".$second;
                    echo "<br/>State:: ".$third;
                    echo "<br/>Country:: ".$fourth;
                }
                else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth == 'null' && $fifth == 'null' ) {
                    echo "<br/>City:: ".$first;
                    echo "<br/>State:: ".$second;
                    echo "<br/>Country:: ".$third;
                }
                else if ( $first != 'null' && $second != 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
                    echo "<br/>State:: ".$first;
                    echo "<br/>Country:: ".$second;
                }
                else if ( $first != 'null' && $second == 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
                    echo "<br/>Country:: ".$first;
                }
            }
        }


}
?>