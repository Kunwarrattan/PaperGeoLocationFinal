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

$query = "SELECT * FROM `addresses_ca2000` ";
$result = mysqli_query($link, $query);

//echo $query.'<br />';

if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['id_art'];
//        $ordre = $row['ordre'];

        $query1 = "SELECT * FROM ` addresses` where  `id_art` = $id";
        $result1 = mysqli_query($link, $query1);

        if($result1->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result1)) {
               // $py = $row['Publication_year'];

                $id1 = $row['id_art'];
                $ordre1 = $row['ordre'];
                $inst = $row['institution'];
                $ville = $row['ville'];
                $pro = $row['province'];
                $con = $row['Country'];
                $latlng = $row['latlongID'];
                $mapi = $row['mapID'];

                $query2 = "insert into `addresses` (`id_art`,`ordre`,`institution`,`ville`,`province`,`Country`,`latlongID`,`mapID`)".
                                    "VALUES ($id1,$ordre1,\"$inst\",\"$ville\",\"$pro\",\"$con\",$latlng,$mapi)";
                echo "<br/>".$query2;
                $result2 = mysqli_query($link,$query2);
                break;
            }
        }
    }
}