<?php
header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
/**
 * Created by PhpStorm.
 * User: india
 * Date: 4/18/2015
 * Time: 5:51 PM
 */


require 'database.php';
$rowid = null;
$k=1;

for($index=1;$index<50000;$index=$index+50){
//$index = 2;
    $query2 = 'SELECT * FROM `address_unique` where `latlongid` is NULL  Limit '.($index*1).", 50 ";
    $result2 = mysqli_query($link, $query2);
    //echo $result2->num_rows."<br/>";
    if($result2->num_rows>0){
    while ($row = mysqli_fetch_assoc($result2)) {
        $idN  = $row['institute'];
            $id = $row['id'];
            $inst = $row['institute'];
            $ville = $row['ville'];
            $province = $row['province'];
            $Country = $row['Country'];
               // echo "<br/>".$inst."------<br/>";
                $query1 = "SELECT * FROM `address_unique` where `latlongid` is NOT NULL and `ville` = \"$ville\" and `province` = \"$province\" and `Country` = \"$Country\" ";
                $result1 = mysqli_query($link, $query1);
              //  echo "<br />".$query1;
               // echo $result1->num_rows;
                if($result1->num_rows>0) {
                    while ($row = mysqli_fetch_assoc($result1)) {
                        if ($id != $row['id']) {
                                echo $id."  =  ".$row['id'] . " <- Level 1 match------" . $k . "------------>  " . $row['institute'] . "     <-------------------->  " . $inst;
                                echo "<br />";
                                $newID = $row['latlongid'];
                                $queryUpdate = "\n UPDATE `address_unique` set `latlongid` = $newID WHERE `id` = $id";
                                $result9 = mysqli_query($link, $queryUpdate);
                                $k++;
                                break;
                                }
                        }
                    }
                }
    }
}