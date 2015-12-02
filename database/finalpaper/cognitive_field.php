<?php
/**
 * Created by PhpStorm.
 * User: Kunwar Rattan
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

$query = 'SELECT * FROM `paired_links_valid` where `Cognitive_dist` is NULL ';
$result = mysqli_query($link, $query);

//echo $query.'<br />';

if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $P_id = $row['Paper_ID'];	
		$P_FIELD = $row['P_Field'];
		$P_SUB_FIELD=$row['P_Subfield'];
		$C_Cited_paper_ID = $row['Cited_paper_ID'];
		$C_C_Field = $row['C_Field'];
		$C_C_Subfield = $row['C_Subfield'];
		$update = 0;
		if($P_SUB_FIELD == $C_C_Subfield){
			$update = 1; 
		}else if($P_FIELD == $C_C_Field ){
			$update = 2;
		}else{
			$update = 3;
		}
		$query2 = "UPDATE `paired_links_valid` SET `Cognitive_dist` = $update where `Paper_ID` = $P_id and `Cited_paper_ID` = $C_Cited_paper_ID";
		//echo "<br/>".$query2;
        $result2 = mysqli_query($link,$query2);
        
		
    }
}
//}
echo "<br/> I'm done";