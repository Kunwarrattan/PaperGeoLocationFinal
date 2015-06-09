<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/29/2015
 * Time: 5:11 PM

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

$id = null;
$distance = null;
$time = null;

if(isset($_REQUEST['id']) && $_REQUEST['id']!="") {
    $id=($_REQUEST['id']);
}

if(isset($_REQUEST['distance']) && $_REQUEST['distance']!="") {
    $distance=($_REQUEST['distance']);
}
if(isset($_REQUEST['time']) && $_REQUEST['time']!="") {
    $time=($_REQUEST['time']);
}


$query =  "update `distance` set `DrivingDistance` = $distance , `DrivingTime` = \"$time\" where `id` = $id";
$result1 = mysqli_query($link, $query);
echo $query;
