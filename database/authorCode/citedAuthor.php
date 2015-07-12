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

if (!$link = mysqli_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}
if (!mysqli_select_db($link,'geolocation')) {
    echo 'Could not select database';
    exit;
}
$query = "SELECT distinct(`Cited_ID_Art`),`Publication_year` FROM `cited_papers` LIMIT 1,10"  ;
echo
$result = mysqli_query($link, $query);
//echo "<br/>".$query;‏
if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<br/>-------------------------------------------";

        $author_ID = $row['Cited_ID_Art'];
        $pyear = $row['Publication_year'];

        $query1 = " SELECT `Nom` FROM `cited_papers_authors` where `Cited_ID_Art`  = $author_ID ";

        $result1 = mysqli_query($link, $query1);

        echo "<br/>" . $query1;

        if ($result1->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $Nom = $row['Nom'];
                $idN = null;

                $query2 = " INSERT INTO `cited_coauthors`( `Authors`, `Title`,`Year`) VALUES (\"$Nom\",$author_ID, $pyear)";
                echo "<br/>" . $query2;

                mysqli_set_charset($link, "utf8");
                mysqli_query($link, "SET NAMES 'utf8'");
                mysqli_query($link, "SET CHARACTER SET 'utf8'");
                $result2 = mysqli_query($link, $query2);

                $idN = mysqli_insert_id($link);

                if ($idN == null) {
                    $newAuthor = "";
                    $query3 = "SELECT `id`,`Authors` FROM `cited_coauthors` where `Title` = $author_ID ";
                    $result3 = mysqli_query($link, $query3);
                    echo "<br/>".$query3;
                    $flag = 0;
                    while ($row = mysqli_fetch_assoc($result3)) {

                        $idN  = $row['id'];

                        $authorname = $row['Authors'];

                        $newAuthor = $authorname.", ".$Nom;
                        echo "<br/>".$authorname."=".$Nom;

                        if(stristr($authorname,$Nom)){
                            echo "<br/>".$flag;
                            $flag = 1;
                        }
                    }
                    if($flag == 0){
                        $queryUpdate ="\n UPDATE `cited_coauthors` set `Authors` = \"$newAuthor\" WHERE `id` = $idN";
                        $result6 = mysqli_query($link, $queryUpdate);
                        echo "<br/>".$queryUpdate;
                    }
                }
            }

        }
    }


}