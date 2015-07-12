<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 7/11/2015
 * Time: 10:09 AM
 */

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!$link = mysqli_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysqli_select_db($link,'geolocation')) {
    echo 'Could not select database';
    exit;
}

$query = "SELECT * FROM `addresses_ca` where  `YOP` is NULL";
$result = mysqli_query($link, $query);

//echo $query.'<br />';

if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['id_art'];
        $ordre = $row['ordre'];

        $query1 = "SELECT `Publication_year` FROM `Publication_year` where  `id_art` = $id ";
        $result1 = mysqli_query($link, $query1);

        if($result1->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $py = $row['Publication_year'];
                $query2 = "update `addresses_ca` set `YOP` = $py where `id_art` = $id and `ordre` = $ordre ";
                echo "<br/>".$query2;
                $result2 = mysqli_query($link,$query2);
            break;
            }
        }
    }
}