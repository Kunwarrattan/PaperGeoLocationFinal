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

//for($index=200000;$index<400000;$index=$index+50){

$query = 'SELECT * FROM `cited_authors_copy` where `YOP` is NULL and `Cited_ID_Art` >= 50831256 ';//Limit ';//.($index*1).", 50 ";
$result = mysqli_query($link, $query);

//echo $query.'<br />';

if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['Cited_ID_Art'];
        //$ordre = $row['ordre'];
		
        $query1 = "SELECT `Publication_year` FROM `cited_papers_from08skelcopy` where `Cited_ID_Art` = $id";
        $result1 = mysqli_query($link, $query1);
		//echo "<br/>".$query1;
		
        if($result1->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $py = $row['Publication_year'];
				
				$query2 = "UPDATE `cited_authors_copy` SET `YOP` = \"$py\" where `Cited_ID_Art` = $id";
                echo "<br/>".$query2;
                $result2 = mysqli_query($link,$query2);
            break;
            }
        }
		
		
    }
}
//}
echo "<br/> I'm done";