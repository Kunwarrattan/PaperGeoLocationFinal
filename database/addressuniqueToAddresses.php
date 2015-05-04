<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/1/2015
 * Time: 6:31 PM
 */

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);

require 'database1.php';

for($index=1;$index<1000;$index=$index+50){

    $query1 = 'SELECT * FROM `final_addresses2` Limit '.($index*1).", 50 ";
    $result1 = mysqli_query($link, $query1);
    //echo $result2->num_rows."<br/>";
    if($result1->num_rows>0){
        while ($row = mysqli_fetch_assoc($result1)) {
            $id1 = $row['id'];
            $lat1 = $row['lat'];
            $long1 = $row['long'];
            $city = $row['city'];
            $province = $row['province'];
            $fulladress = $row['full_address'];
            $country = $row['country'];

            $query2 ="SELECT * FROM `final_addresses1` where `lat` = $lat1 and `long` = $long1 ";
            $result2 = mysqli_query($link, $query2);

            if($result2->num_rows>0){
                while ($row = mysqli_fetch_assoc($result2)) {
                    $id2 = $row['id'];
                    $query3 = "UPDATE `address_unique` set `latlongid` = $id2 WHERE `latlongid` = $id1";
                    //$query3 ="SELECT `latlongid` FROM `address_unique` where `latlongid` = $id1 ";
                    $result3 = mysqli_query($link, $query3);
                }
            }else{
                $query4 = "insert into final_addresses1(`lat`,`long`,`full_address`,`city`,`province`,`country`) VALUES ($lat1,$long1,$fulladress,$city,$province,$country)";
                //$query4 ="SELECT `latlongid` FROM `address_unique` where `latlongid` = $id1 ";
                $result4 = mysqli_query($link, $query4);
            }

        }
    }
}