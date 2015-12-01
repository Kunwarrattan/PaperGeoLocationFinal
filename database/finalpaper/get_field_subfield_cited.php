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

$query = 'SELECT * FROM `paired_links_valid` where `C_Field` is NULL and `C_Subfield` is NULL';//Limit ';//.($index*1).", 50 ";
$result = mysqli_query($link, $query);

//echo $query.'<br />';

if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['Cited_paper_ID'];
        //$ordre = $row['ordre'];
		
        $query1 = "SELECT `Field`, `Subfield` FROM `cited_papers_from2007unique` where `Cited_ID_Art` = $id";
        $result1 = mysqli_query($link, $query1);
		//echo "<br/>".$query1;
		
        if($result1->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $pfield = $row['Field'];
				$psubfield = $row['Subfield'];
				
				$query2 = "UPDATE `paired_links_valid` SET `C_Field` = \"$pfield\", `C_Subfield` = \"$psubfield\" where `Cited_paper_ID` = $id";
                //echo "<br/>".$query2;
                $result2 = mysqli_query($link,$query2);
            break;
            }
        }
		
		
    }
}
//}
echo "<br/> I'm done";