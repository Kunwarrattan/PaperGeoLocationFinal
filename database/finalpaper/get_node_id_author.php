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

$query = "SELECT * FROM `addresses_ca_from1011` where `Node_id` is NULL";
$result = mysqli_query($link, $query);

//echo $query.'<br />';

if($result->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result)) {

		$authorname = $row['author_name'];
        //$ordre = $row['ordre'];
		
        $query1 = "SELECT `Node_id`, `Nom` FROM `nodes_0711` where `Nom` = \"$authorname\"";
        $result1 = mysqli_query($link, $query1);
		//echo "<br/>".$query1;		\"$py\"
		
        if($result1->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $nodeid = $row['Node_id'];
				$nom = $row['Nom'];
				
				$query2 = "UPDATE `addresses_ca_from1011` SET `Node_id` = $nodeid  where `author_name` = \"$nom\"";
                //echo "<br/>".$query2;
                $result2 = mysqli_query($link,$query2);
            break;
            }
        }
		
		
    }
}
//}
echo "<br/> I'm done";