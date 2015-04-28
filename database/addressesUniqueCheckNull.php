<?php

require 'database.php';
$j=0;
$query = "SELECT `latlongid`,`id` FROM `address_unique` where  `latlongid` is not NULL and `latlongid` != 0 ";
$result = mysqli_query($link, $query);
//echo $query.'<br />';
if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $latlngID = $row['latlongid'];
        $id = $row['id'];
        //echo $paper_ID;
        $query1 = "SELECT `id` FROM `final_addresses2` WHERE  `id` = $latlngID";

        $result1 = mysqli_query($link, $query1);
        if($result1->num_rows > 0) {
            $j++;
        }else{
            $j++;
            echo "<br />".$query1;
            echo "<br />".$id;
        }

//        while ($row = mysqli_fetch_assoc($result1)) {
//            $uid = $row['id'];
//            echo "<br />".$uid;
//            //$queryUpdate = "UPDATE `authors` set `Pyear` = $pyear WHERE `serial` = $serial";
//            //$result9 = mysqli_query($link, $queryUpdate);
//            break;
//        }
    }
    echo "total =".$j;
}