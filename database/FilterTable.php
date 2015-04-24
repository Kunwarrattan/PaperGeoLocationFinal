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
#for($index=1;$index<10000;$index=$index+50){
$index = 2;
    $query2 = 'SELECT * FROM `address_unique` where `latlongid` is NULL';#'  Limit '.($index*1).", 50 ";
    $result2 = mysqli_query($link, $query2);
    echo $result2->num_rows;
    if($result2->num_rows>0){
    while ($row = mysqli_fetch_assoc($result2)) {
        $idN  = $row['institute'];
            $id = $row['id'];
            $inst = $row['institute'];
            $ville = $row['ville'];
            $province = $row['province'];
            $Country = $row['Country'];

                echo "<br/>".$inst."<br/>";
                $query1 = "SELECT * FROM `address_unique` where `latlongid` is NOT NULL";
                $result1 = mysqli_query($link, $query1);
                echo $result1->num_rows."<br/>";
                if($result1->num_rows>0) {
                    while ($row = mysqli_fetch_assoc($result1)) {
                        if ($ville == $row['ville'] && $province == $row['province'] && $Country == $row['Country'] && $id != $row['id'] && $inst != null && $row['institute'] != null) {
                            $latlong = $row['latlongid'];
                            $length1 = strlen($inst);
                            $length2 = strlen($row['institute']);

                            $str1 = substr($inst,0,$length1/2);
                            $str2 = substr($row['institute'],0,$length2/2);

                            echo $str1." == ". $row['institute'];
                            echo "<br/>".$str2." == ". $inst;
                           // echo $row['id'] . " <-------".$k."------------>  " . $str1 . "     <-------------------->  " . $str2;
                            if($str1 === $str2){
                                #if (stristr($str1, $row['institute']) || stristr($str2, $inst)) {
                                   // echo $row['id'] . " <-------".$k."------------>  " . $str1 . "     <-------------------->  " . $str2;
                                   // echo "<br />";
                                    $newID = $row['latlongid'];
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
    #}
    if (!$query2) {
        echo 'MySQL Error: ' . mysqli_error($link);
        exit;
    }
}
