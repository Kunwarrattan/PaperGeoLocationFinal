<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 4/18/2015
 * Time: 5:51 PM
 */


require 'database.php';
$rowid = null;
$k=1;
for($index=1;$index<10000;$index=$index+50){

    $query2 = 'SELECT * FROM `address_unique` where `latlongid` is NULL Limit '.($index*1).", 50 ";
    $result2 = mysqli_query($link, $query2);
    //echo $result2->num_rows;
    if($result2->num_rows>0){
    while ($row = mysqli_fetch_assoc($result2)) {
        $idN  = $row['institute'];
            $id = $row['id'];
            $inst = $row['institute'];
            $ville = $row['ville'];
            $province = $row['province'];
            $Country = $row['Country'];
                //echo "<br/>".$inst."------<br/>";
                $query1 = "SELECT * FROM `address_unique` where `latlongid` is NOT NULL";
                $result1 = mysqli_query($link, $query1);
               // echo $result1->num_rows;
                if($result1->num_rows>0) {
                    while ($row = mysqli_fetch_assoc($result1)) {
                        if ($ville == $row['ville'] && $province == $row['province'] && $Country == $row['Country'] && $id != $row['id'] && $inst != null && $row['institute'] != null) {
                                if (stristr($inst, $row['institute']) || stristr($row['institute'], $inst)) {
                                    echo $row['id'] . " <-------".$k."------------>  " . $row['institute'] . "     <-------------------->  " . $inst;
                                    echo "<br />";
                                    $newID = $row['id'];
                                    $queryUpdate ="\n UPDATE `address_unique` set `latlongid` = $newID WHERE `id` = $id";
                                    $result9 = mysqli_query($link, $queryUpdate);
                                    echo $queryUpdate;
                                    echo "<br />";
                                    $k++;
                                    break;
                                }
                        }
                    }
                }
        }
    }
    if (!$query2) {
        echo 'MySQL Error: ' . mysqli_error($link);
        exit;
    }
}
