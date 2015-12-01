<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 6/16/2015
 * Time: 5:04 PM
 */


header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!$link = mysqli_connect('localhost', 'root', 'system')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysqli_select_db($link,'geolocation')) {
    echo 'Could not select database';
    exit;
}


$query = ' SELECT `ID_Art`,`Ordre`,`Nom`,`Pyear` FROM `authors_missing`' ;

$result = mysqli_query($link, $query);
echo "<br/>".$query;
if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<br/>-------------------------------------------";
        $author_ID = $row['ID_Art'];
        $ordre = $row['Ordre'];
        $Nom = $row['Nom'];
        $year = $row['Pyear'];
        $idN = null;
        echo "<br/>".$author_ID." = ".$ordre;
        $query2 = " INSERT INTO `coauthors`( `Authors`, `Title`,`Year`) VALUES (\"$Nom\",$author_ID, $year)";
        //mysqli_query("utf8",$query);
        //echo "<br/>".$query2;
        mysqli_set_charset($link, "utf8");
        mysqli_query($link, "SET NAMES 'utf8'");
        mysqli_query($link, "SET CHARACTER SET 'utf8'");
        $result2 = mysqli_query($link, $query2);
        $newAuthor = "";
        $idN = mysqli_insert_id($link);
        if($idN == null){
            $query3 = "SELECT * FROM `coauthors` where `Title` = $author_ID ";
            $result3 = mysqli_query($link, $query3);
            echo "<br/>".$query3;
            $flag = 0;
            while ($row = mysqli_fetch_assoc($result3)) {
                $idN  = $row['Title'];

                $authorname = $row['Authors'];

                $newAuthor = $authorname.", ".$Nom;
                echo "<br/>".$authorname."=".$Nom;

                if(stristr($authorname,$Nom)){
                    echo "<br/>".$flag;
                    $flag = 1;
                }
            }
            if($flag == 0){
                $queryUpdate ="\n UPDATE `coauthors` set `Authors` = \"$newAuthor\" WHERE `Title` = $idN ";
                $result6 = mysqli_query($link, $queryUpdate);
                echo "<br/>".$queryUpdate;
            }
        }
    }
}