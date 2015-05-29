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
    $addCFID = $row['P_order'];
    $orderF = $row['Cited_paper_ID'];
    $orderCPF = $row['C_order'];

    $latLongIDF = 0;
    $latLongIDCPF = 0;

    $query2 =   "SELECT `latlongID` FROM `addresses` WHERE `id_art` = $addFID `ordre` = $orderF";
    $result2 = mysqli_query($link, $query2);
    while ($row = mysqli_fetch_assoc($result2)) {
        $latLongIDF = $row['latlongID'];
        }


    $query3 =   "SELECT `latlongID` FROM `cited_papers_addresses` WHERE `Cited_ID_Art` = $addCFID `ordre` = $orderCPF";
    $result3 = mysqli_query($link, $query13);
    while ($row = mysqli_fetch_assoc($result3)) {
        $latLongIDCPF = $row['latlongID'];
    }

    if($latLongIDF != 0 && $latLongIDCPF != 0){
        $lat1 = 0.00000;
        $lat2 = 0.00000;
        $lng1 = 0.00000;
        $lng2 = 0.00000;
        $query4 =   "SELECT * FROM `final_addresses` WHERE `id` = $latLongIDF";
        $result4 = mysqli_query($link, $query4);
        while ($row = mysqli_fetch_assoc($result4)) {
            $lat1 = $row['lat'];
            $lng1 = $row['lng'];
        }
        $query5 =   "SELECT * FROM `final_addresses` WHERE `id` = $latLongIDCPF";
        $result5 = mysqli_query($link, $query5);
        while ($row = mysqli_fetch_assoc($result5)) {
            $lat2 = $row['lat'];
            $lng2 = $row['lng'];
        }

        $query6 =  "INSERT INTO `distance`(`lat1`, `lng1`, `lat2`, `lng2`) VALUES ($lat1,$lng1.$lat2,$lng2)";
        $result = mysqli_query($link, $query6);
        $idN = mysqli_insert_id($link);
        $query2 = null;
        if($idN == null){
            $query7 = "SELECT `id` FROM `distance` where `lat1` = $lat1 and `lng1` = $lng1 and  `lat2` = $lat2 and `lng2` = $lng2 ";
            $result7 = mysqli_query($link, $query7);
            while ($row = mysqli_fetch_assoc($result7)) {
                $id = $row['id'];
                $update = " Update `main_database` SET `mapID` = $id where `Paper_ID`= $addFID and `P_order`= $orderF and `Cited_paper_ID`= $addCFID and `C_order`= $orderCPF ";
                $updateresult = mysqli_query($link, $update);
            }
        }else{
            $FlyingDistance = distance($lat1, $lng1, $lat2, $lng2, "K"); //Distance in kilometers
            $time = timeCal($FlyingDistance);   // Time in minutes
            $FlyingTime  = display($time);      // Time Foramt in HH:MM:SS


            $query7 =  "INSERT INTO `distance`(`lat2`, `lng2`, `lat1`, `lng1`, `FlyingDistance`, `FlyingTime`) VALUES ($lat1,$lng.$lat2,$lng2,$FlyingDistance,$FlyingTime)";
            $result = mysqli_query($link, $query7);

            $updateNew = " Update `distance` SET  `FlyingDistance` = $FlyingDistance, `FlyingTime` = $FlyingTime where `lat1` = $lat1 and `lng1` = $lng1 and  `lat2` = $lat2 and `lng2` = $lng2 ";
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