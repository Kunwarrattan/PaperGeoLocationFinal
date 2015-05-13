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
$flag2 = 0;
$query1 = " SELECT * FROM `final_addresses_old` "; //Limit '.($index*1).",100
$result1 = mysqli_query($link, $query1);

        if($result1->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $id = $row['id'];
                $province = $row['province'];
                $country = $row['country'];
                $flag = 1;

                $query2 = " SELECT * FROM `final_addresses2` where `id` = $id"; //Limit '.($index*1).",100
                echo "";
                $result2 = mysqli_query($link, $query2);

                    if ($result2->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $flag =0;
                            if($province != $row['province'] && $country != $row['country'] ){
                                echo "<br/> ===================================== ";
                                echo "<br />LatLong ID = ".$id."  Old table = ".$country. "  New table = ". $row['country'];


                                $query3 = " SELECT * FROM `address_unique` where `latlongid` = $id"; //Limit '.($index*1).",100
                                $result3 = mysqli_query($link, $query3);

                                if ($result3->num_rows > 0) {
                                    while ($row = mysqli_fetch_assoc($result3)) {
                                        echo "<br />";
                                        echo "ID = ".$row['id'];
                                        echo " Country Should be = ".$row['Country'];
                                    }
                                }
                                echo "<br/> ===================================== ";

                            }

                        }
                    }
                if($flag==1){
                    echo "<br /> ID = ".$id." not there in new table " ;
                    $flag2 = 1;
                    $query3 = " SELECT `id`,`Country` FROM `address_unique` where `latlongid` = $id"; //Limit '.($index*1).",100
                    $result3 = mysqli_query($link, $query3);

                    if ($result3->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result3)) {
                            $flag2 = 0;

                            echo "not found";
                            if($country != $row['Country']){
                                    echo "<br />";
                                    echo "ID = ".$row['id'];
                                    echo " Country Should be in old table  = ".$row['Country'];
                            }else{
                                echo "<br />";
                                echo "ID = ".$row['id'];
                                echo " Country = ".$row['Country'];
                            }
                        }
                        if($flag2 == 1){
                            echo "<br /> ID = ".$id." not there in old table as well" ;
                        }
                    }
                }
            }
        }

?>

