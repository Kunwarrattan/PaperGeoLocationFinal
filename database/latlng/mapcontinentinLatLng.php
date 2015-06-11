<?php
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


$query1 =   "SELECT `id`,`country` FROM `final_addresses` WHERE `country` != \"\"  and `continent` is NULL ";
$result1 = mysqli_query($link, $query1);
while ($row = mysqli_fetch_assoc($result1)) {
    $id = $row['id'];
    $country1 = $row['country'];

    $query4 =   "SELECT * FROM `countries` where `name` = \"$country1\" or `native` = \"$country1\" ";
    $result4 = mysqli_query($link, $query4);
    echo "<br />".$query4;
    if($result4->num_rows>0){
        $continent = "";
        while ($row = mysqli_fetch_assoc($result4)) {
            $continent = $row['continent'];
        }
        $update = "Update `final_addresses` SET `continent` = \"$continent\" where `id`= $id ";
        echo "<br/>".$update;
        $updateresult = mysqli_query($link, $update);
    }
}
//
//$query1 =   "SELECT `code`,`continent1` FROM `countries` ";
//$result1 = mysqli_query($link, $query1);
//while ($row = mysqli_fetch_assoc($result1)) {
//    $id = $row['code'];
//    $country1 = $row['continent1'];
//
//    $query4 =   "SELECT * FROM `continents` where `code` = \"$country1\" ";
//    $result4 = mysqli_query($link, $query4);
//    echo "<br/>".$query4;
//    if($result4->num_rows>0){
//        $continent = "";
//        while ($row = mysqli_fetch_assoc($result4)) {
//            $continent = $row['name'];
//
//        }
//        $update = "Update `countries` SET `continent` = \"$continent\" where `code`= \"$id\" ";
//        echo "<br/>".$update;
//        $updateresult = mysqli_query($link, $update);
//
//    }
//
//
//}
