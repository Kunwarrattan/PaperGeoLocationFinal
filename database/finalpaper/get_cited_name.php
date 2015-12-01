<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 7/11/2015
 * Time: 10:09 AM
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

$query = "SELECT * FROM `cited_addresses_ca3years` where `Author_name` is NULL";
$result = mysqli_query($link, $query);

//echo $query.'<br />';

if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['Cited_ID_Art'];
        $ordre = $row['ordre'];

        $query1 = "SELECT `Nom` FROM `cited_papers_authors` where `Cited_ID_Art` = $id and `ordre` = $ordre";
        $result1 = mysqli_query($link, $query1);
		echo "<br/>".$query1;
		
        if($result1->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $nom = $row['Nom'];
				$query2 = "UPDATE `cited_addresses_ca3years` set `Author_name` = \"$nom\" where `Cited_ID_Art` = $id and `ordre` = $ordre";
                echo "<br/>".$query2;
                $result2 = mysqli_query($link,$query2);
            break;
            }
        }
    }
}
//}
echo "<br/> I'm done";