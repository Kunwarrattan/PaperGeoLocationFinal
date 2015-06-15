<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/1/2015
 * Time: 6:31 PM
 */

//this file is mapping data to the addresses form address unique

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!$link = mysqli_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysqli_select_db($link,'filtereddb')) {
    echo 'Could not select database';
    exit;
}

//for($index=1;$index<1000;$index=$index+100){

//for($index =1 ;$index <100 ;$index= $index+50)
//{
    $query1 = ' SELECT * FROM `addresses` where `mapID` is NULL'; // Limit '.($index*1).",50 ";
    $result1 = mysqli_query($link, $query1);

    if($result1->num_rows>0){
        while ($row = mysqli_fetch_assoc($result1)) {
            $id1 = $row['id_art'];
            $order = $row['ordre'];
            $inst = $row['institution'];
            $ville = $row['ville'];
            $province = $row['province'];
            $country = $row['Country'];
            $latlongID = NULL;

            $query = "INSERT INTO `address_unique`( `institute`, `ville`, `province`,`Country`) VALUES (\"$inst\",\"$ville\",\"$province\",\"$country\")";
            //mysqli_query("utf8",$query);
            echo "<br/>".$query;
            mysqli_set_charset($link, "utf8");
            mysqli_query($link, "SET NAMES 'utf8'");
            mysqli_query($link, "SET CHARACTER SET 'utf8'");
            $result = mysqli_query($link, $query);

            $idN = mysqli_insert_id($link);
            echo "->".$idN;

            $query2 = null;
            if($idN == null){
                $query2 = "SELECT `id`,`latlongid` FROM `address_unique` where `institute`= \"$inst\" AND `ville` = \"$ville\" AND  `province` = \"$province\" AND `Country` = \"$country\" ";
                $result2 = mysqli_query($link, $query2);
                echo "<br/>".$query2;
                while ($row = mysqli_fetch_assoc($result2)) {
                    $idN  = $row['id'];
                    $latlongID = $row['latlongid'];

                }
            }
            echo "->".$idN;
            $queryUpdate ="UPDATE `addresses` set `latlongID` = $latlongID , `mapID` = $idN  WHERE `id_art` = $id1 and `ordre` = $order ";
            $result4 = mysqli_query($link, $queryUpdate);
            echo "<br/>".$queryUpdate;


        }
    }
//}