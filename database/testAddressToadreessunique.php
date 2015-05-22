<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/1/2015
 * Time: 6:31 PM
 */


header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);

require 'database.php';

//for($index=1;$index<1000;$index=$index+100){

$index = 1;

    $query1 = ' SELECT * FROM `addresses` where mapID is NULL  Limit '.($index*1).",10 ";
    $result1 = mysqli_query($link, $query1);

    if($result1->num_rows>0){
        while ($row = mysqli_fetch_assoc($result1)) {
            $id1 = $row['id_art'];
            $order = $row['ordre'];
            $inst  = $row['institution'];
            $ville = $row['ville'];
            $province = $row['province'];
            $country = $row['Country'];

            //echo $row['id_art']." ".$row['ordre']."<br />";

            $query2 = "INSERT INTO `address_unique_test` (`institute`, `ville`, `province`, `Country`) VALUES ".
                            "(\"$inst\",\"$ville\",\"$province\",\"$country\")";

            echo $query2."<br/>";

            mysqli_set_charset($link, "utf8");
            mysqli_query($link, "SET NAMES 'utf8'");
            mysqli_query($link, "SET CHARACTER SET 'utf8'");
            $result2 = mysqli_query($link, $query2);

            $idN = mysqli_insert_id($link);

           if($idN == null){
                $query3 = "SELECT `id` FROM `address_unique_test` where `institute` = \"$inst\" and `ville` = \"$ville\"  and `province` = \"$province\" and `Country` = \"$country\"";
                echo $query3."<br/>";
                $result2 = mysqli_query($link, $query3);
                while ($row = mysqli_fetch_assoc($result2)) {
                    $idN  = $row['id'];
                }
            }
//
//
            $queryUpdate ="UPDATE `addresses` set `mapID` = $idN WHERE `id_art` = $id1 and `ordre` = $order";
            $result5 = mysqli_query($link, $queryUpdate);
            echo $queryUpdate."<br />";


        }
   // }
   //
   //
        if (!$result5) {
            echo "\n DB Error, could not query the database\n";
            echo 'MySQL Error: ' . mysqli_error($link);
            //exit;
        }
    }