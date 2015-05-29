<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/28/2015
 * Time: 7:25 PM
 */


header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!$link = mysqli_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysqli_select_db($link,'geotest')) {
    echo 'Could not select database';
    exit;
}

$query1 =   "SELECT * FROM `main_database` WHERE `mapID` is null ";
$result1 = mysqli_query($link, $query1);
while ($row = mysqli_fetch_assoc($result1)) {

    $addFID = $row['Paper_ID'];
    $orderF = $row['P_order'];
    $addCFID= $row['Cited_paper_ID'];
    $orderCPF = $row['C_order'];

    echo "<br />".$addFID. "   =    " . $addCFID;

    $latLongIDF = 0;
    $latLongIDCPF = 0;

    $query2 =   "SELECT `latlongID` FROM `addresses` WHERE `id_art` = $addFID and `ordre` = $orderF ";
    $result2 = mysqli_query($link, $query2);
    echo "<br />".$query2;
    if($result2->num_rows>0){
    while ($row = mysqli_fetch_assoc($result2)) {
        $latLongIDF = $row['latlongID'];
       // break;
        }
    }

    $query3 =   "SELECT `latlongID` FROM `cited_papers_addresses` WHERE `Cited_ID_Art` = $addCFID AND `ordre` = $orderCPF ";
    echo "<br />".$query3;
    $result3 = mysqli_query($link, $query3);
    if($result3->num_rows>0) {
        while ($row = mysqli_fetch_assoc($result3)) {
            $latLongIDCPF = $row['latlongID'];
           // break;
        }
    }
    if($latLongIDF != 0 && $latLongIDCPF != 0){
        $lat1 = 0.00000;
        $lat2 = 0.00000;
        $lng1 = 0.00000;
        $lng2 = 0.00000;
        $city1 = null;
        $city2 = null;
        $state1 = null;
        $state2 = null;
        $country1 = null;
        $country2 = null;


        $query4 =   "SELECT * FROM `final_addresses` WHERE `id` = $latLongIDF";
        $result4 = mysqli_query($link, $query4);
        while ($row = mysqli_fetch_assoc($result4)) {
            $lat1 = $row['lat'];
            $lng1 = $row['lng'];
            $city1 = $row['city'];
            $state1 = $row['province'];
            $country1 = $row['country'];

          //  break;
        }
        $query5 =   "SELECT * FROM `final_addresses` WHERE `id` = $latLongIDCPF";
        $result5 = mysqli_query($link, $query5);
        while ($row = mysqli_fetch_assoc($result5)) {
            $lat2 = $row['lat'];
            $lng2 = $row['lng'];
            $city2 = $row['city'];
            $state2 = $row['province'];
            $country2 = $row['country'];

            //  break;
        }

        $query6 =  "INSERT INTO `distance`(`lat1`, `lng1`, `lat2`, `lng2`) VALUES ($lat1,$lng1,$lat2,$lng2)";
        echo "<br/>".$query6;
        $result = mysqli_query($link, $query6);
        $idN = mysqli_insert_id($link);
        echo "<br/>".$idN;
        $query2 = null;
        if($idN == 0){
            $query7 = "SELECT `id` FROM `distance` where `lat1` = $lat1 and `lng1` = $lng1 and  `lat2` = $lat2 and `lng2` = $lng2 ";
            echo "<br/>".$query7;
            $result7 = mysqli_query($link, $query7);
            while ($row = mysqli_fetch_assoc($result7)) {
                $id = $row['id'];
                $update = "Update `main_database` SET `mapID` = $id where `Paper_ID`= $addFID and `P_order`= $orderF and `Cited_paper_ID`= $addCFID and `C_order`= $orderCPF ";
                echo "<br/>".$update;
                $updateresult = mysqli_query($link, $update);
                break;
            }
        }else{
            $update = "Update `main_database` SET `mapID` = $idN where `Paper_ID`= $addFID and `P_order`= $orderF and `Cited_paper_ID`= $addCFID and `C_order`= $orderCPF ";
            echo "<br/>".$update;
            $updateresult = mysqli_query($link, $update);

            $FlyingDistance = distance($lat1, $lng1, $lat2, $lng2, "K"); //Distance in kilometers
            $time = timeCal($FlyingDistance);   // Time in minutes
            $FlyingTime  = display($time);      // Time Foramt in HH:MM:SS
            $category = null;
            $cat = null;

            if($city1 == $city2){
                $category = 1;
                $cat = "Same City";

            }else if($state1 == $state2){
                $category = 2;
                $cat = "Same Province";

            } else if($country1 == $country2) {
                $category = 3;
                $cat = "Same Country";
            }
//            }else if($continent1 == $country2){
//                $category = 4;
//                $cat = "Same Continent";
//            }
            else{
                $category = 5;
                $cat = "Different Continent";
            }

            $query7 =  "INSERT INTO `distance`(`lat2`, `lng2`, `lat1`, `lng1`, `FlyingDistance`, `FlyingTime`, `Category`) VALUES ($lat1,$lng1,$lat2,$lng2,$FlyingDistance,\"$FlyingTime\",$category)";
            echo "<br />".$query7;
            $result7 = mysqli_query($link, $query7);



            $updateNew = " Update `distance` SET  `FlyingDistance` = $FlyingDistance, `FlyingTime` = \"$FlyingTime\", `Category` = $category where `lat1` = $lat1 and `lng1` = $lng1 and  `lat2` = $lat2 and `lng2` = $lng2 ";
            echo "<br />".$updateNew;
            $resultNew = mysqli_query($link, $updateNew);
        }
    }
}



function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function display($seconds) {
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}

function timeCal($distance){
    $speed = 885;           //747 Jumbo Jet assumption http://hypertextbook.com/facts/2002/JobyJosekutty.shtml
    $time = ($distance/$speed);
    return $time*60;
}