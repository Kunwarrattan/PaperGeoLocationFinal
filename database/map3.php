<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/12/2015
 * Time: 8:18 PM
 */

//this file is used to correct the final addressees for third file


error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!$link = mysqli_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysqli_select_db($link,'geolocation_test')) {
    echo 'Could not select database';
    exit;
}

$flag = 0 ;
$query1 = " SELECT * FROM `final_addresses_old` "; //Limit '.($index*1).",100
$result1 = mysqli_query($link, $query1);

        if($result1->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $id = $row['id'];
                $province = $row['province'];
                $country = $row['country'];
                $flag = 1;
                $query2 = " SELECT * FROM `final_addresses2` where `id` = $id"; //Limit '.($index*1).",100
                $result2 = mysqli_query($link, $query2);

                    if ($result2->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            if($province != $row['province'] && $country != $row['country'] ){
                                echo "<br />Old table = ".$country. "new table = ". $row['country'];

                                $flag =0;
                                $query3 = " SELECT `id`,`Country` FROM `address_unique` where `latlongid` = $id"; //Limit '.($index*1).",100
                                $result3 = mysqli_query($link, $query3);

                                if ($result3->num_rows > 0) {
                                    while ($row = mysqli_fetch_assoc($result3)) {
                                        echo "<br />".$row[`id`]." Country = ".$row['Country'];
                                    }
                                }
                                echo "<br/> ===================================== ";

                            }

                        }
                    }
                if($flag==1){
                    echo "<br /> ID = ".$id." not there in new table " ;
                }
            }
        }

?>

