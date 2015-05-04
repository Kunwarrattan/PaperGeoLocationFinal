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

for($index=1;$index<10000;$index=$index+100){

    $query1 = 'SELECT * FROM `address_unique` Limit '.($index*1).", 100 ";
    $result1 = mysqli_query($link, $query1);
    //echo $result2->num_rows."<br/>";
    if($result1->num_rows>0){
        while ($row = mysqli_fetch_assoc($result1)) {
            $id1 = $row['id'];
            $inst = $row['institute'];
            $ville = $row['ville'];
            $province = $row['province'];
            $country = $row['Country'];
            $latlong1 = $row['latlongid'];


            $query2 ='SELECT * FROM `cited_paper_address` ';
            $result2 = mysqli_query($link, $query2);

            if($result2->num_rows>0){
                while ($row = mysqli_fetch_assoc($result2)) {
                   $id2 = $row['Cited_ID_Art'];
                    $order = $row['ordre'];
                    //where `institution` = $inst and `ville` = $ville and `province` =  $province and `Country` = $country
                    $institution = $row['institution'];
                    $ville2 = $row['ville'];
                    $province2 = $row['province'];
                    $Country2 = $row['Country'];
                    if($inst == $institution && $ville == $ville2 && $province == $province2 && $country == $Country2){
                        echo "<br />".$inst." = " . $ville . " = " . $province . " = " . $country;
                        $query3 = "UPDATE `cited_paper_address` set `latlongID` = $latlong1 WHERE `Cited_ID_Art` = $id2 and `ordre` = $order";
                        //$query3 ="SELECT `latlongid` FROM `address_unique` where `latlongid` = $id1 ";
                        $result3 = mysqli_query($link, $query3);
                    }
                }
            }
//            }else{
//                $query4 = "insert into final_addresses1(`lat`,`long`,`full_address`,`city`,`province`,`country`) VALUES ($lat1,$long1,$fulladress,$city,$province,$country)";
//                //$query4 ="SELECT `latlongid` FROM `address_unique` where `latlongid` = $id1 ";
//                $result4 = mysqli_query($link, $query4);
//            }

        }
    }
}