<?php

require 'database.php';

$query = 'SELECT `id_art` ,`Publication_year` FROM `papers` ';  #where `latlongid` is NULL Limit '.($index*1).", 50 ";

echo $query;
echo "<br/>";

$result = mysqli_query($link, $query);

if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $paper_ID = $row['id_art'];
        $publication_year = $row['Publication_year'];


        $query2 = "SELECT * FROM `author` where  `id_art` = $paper_ID";
        echo $query2;
        echo "<br/>";
        $result2 = mysqli_query($link, $query2);
        if ($result2->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result2)) {

                $order = $row['Ordre'];
                $pnAME = $row['Nom'];
                echo "<br/>";

                $query6 = "INSERT INTO `coauthorship`( `paperID`,`ordre`, `YOP`,`PName`) VALUES ($paper_ID,$order,$publication_year,\"$pnAME\")";
                echo $query6;
                echo "<br/>";
                mysqli_set_charset($link, "utf8");
                mysqli_query($link, "SET NAMES 'utf8'");
                mysqli_query($link, "SET CHARACTER SET 'utf8'");
                mysqli_query($link, $query6);
            }
        }
    }
}