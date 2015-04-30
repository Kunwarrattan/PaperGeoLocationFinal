<?php

require 'database.php';
for($index=1;$index<10000;$index=$index+50){
    $query = 'SELECT `serial`,`ID_Art` FROM `authors` where  `Pyear` is NULL Limit '.($index*1).", 50 ";
    $result = mysqli_query($link, $query);
    if($result->num_rows>0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $paper_ID = $row['ID_Art'];
            $serial = $row['serial'];
            echo $paper_ID;
            $query1 = "SELECT `Publication_year` FROM `papers` WHERE  `id_art` = $paper_ID";
            echo $query1;
            $result1 = mysqli_query($link, $query1);
            while ($row = mysqli_fetch_assoc($result1)) {
                $pyear = $row['Publication_year'];
                $queryUpdate = "UPDATE `authors` set `Pyear` = $pyear WHERE `serial` = $serial";
                $result9 = mysqli_query($link, $queryUpdate);
                break;
            }
        }
    }
}