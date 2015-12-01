<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 7/11/2015
 * Time: 10:09 AM
 */

//cited_authors_mysample
//cited_papers_from2008_byca
//addresses_ca_from1011

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
$array = Array(4000);
$queryTop = 'SELECT DISTINCT(`id_art`) FROM `addresses_ca_from1011` ' ;
$resultTop = mysqli_query($link, $queryTop);

		if($resultTop->num_rows>0) {
			$i=0;
			while ($row = mysqli_fetch_assoc($resultTop)) {
				$array[$i] = $row['id_art'];
				$i++;
			}
		}
		//echo $array[10];
		//$rand_keys = array_rand($array, 1);
		//echo "<br/>".$rand_keys;
		$query = 'SELECT * FROM `cited_authors_mysample` where `Citing` = 0 ';

		$result = mysqli_query($link, $query);

		if($result->num_rows>0) {
			while ($row = mysqli_fetch_assoc($result)) {
					$C_Cited_ID_Art = $row['Cited_ID_Art'];
					$C_Ordre = $row['Ordre'];
					$C_Nom = $row['Nom'];
					$C_YOP = $row['YOP'];
					$C_Citing = $row['Citing'];
						
						$rand = array_rand($array, 1);
						echo "<br/>".$array[$rand];
						$query2 = "SELECT * FROM `addresses_ca_from1011` where `id_art` = $array[$rand]";
						$result2 = mysqli_query($link, $query2);
						//echo "<br/>".$query2;
						
						if($result2->num_rows>0) {
							while ($row = mysqli_fetch_assoc($result2)) {
								
								$P_id_art = $row['id_art'];
								$P_ordre = $row['ordre'];
								$P_author_name = $row['author_name'];
								$P_YOP = $row['YOP'];
								
								
								$QUERY3 = "insert IGNORE into paired_links_valid (`Paper_ID`,`P_order`,`P_Author`,`P_year`,`Cited_paper_ID`,`C_order`,`C_Author`,`C_year`,`Citing`,Count) ".
															"Values($P_id_art,$P_ordre,\"$P_author_name\",$P_YOP,$C_Cited_ID_Art,$C_Ordre,\"$C_Nom\",$C_YOP,$C_Citing,0)";
								mysqli_query($link, "SET CHARACTER SET 'utf8'");
								mysqli_query($link, $QUERY3);
								//echo "<br/>".$QUERY3;
								break;
							}
						}	
						
					}				
		}
		echo "i am done";

?>