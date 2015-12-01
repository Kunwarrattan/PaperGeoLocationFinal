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

$query = 'SELECT * FROM `paired_links_valid` where `P_Field` is NULL and `P_Subfield` is NULL';//Limit ';//.($index*1).", 50 ";
$result = mysqli_query($link, $query);

//echo $query.'<br />';

if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['Paper_ID'];
        //$ordre = $row['ordre'];
		
        $query1 = "SELECT `Field`, `Subfield` FROM `papers_fromca1011` where `id_art` = $id";
        $result1 = mysqli_query($link, $query1);
		//echo "<br/>".$query1;
		
        if($result1->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $pfield = $row['Field'];
				$psubfield = $row['Subfield'];
				
				$query2 = "UPDATE `paired_links_valid` SET `P_Field` = \"$pfield\", `P_Subfield` = \"$psubfield\" where `Paper_ID` = $id";
                //echo "<br/>".$query2;
                $result2 = mysqli_query($link,$query2);
            break;
            }
        }
		
		
    }
}
//}
echo "<br/> I'm done";