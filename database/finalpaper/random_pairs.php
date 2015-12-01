<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 7/11/2015
 * Time: 10:09 AM
 */

//cited_authors_mysample
//cited_papers_from2008_byca
//addresses_ca2011only

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


		$query = 'SELECT * FROM `cited_authors_mysample` where `Citing` = 1 ';

		$result = mysqli_query($link, $query);
		$m=0;$count=0;$y=0;
		if($result->num_rows>0) {
			echo "<br/>".$m;
			echo "<br/>".$result->num_rows;
			while ($row = mysqli_fetch_assoc($result)) {
				$m++;
					$C_Cited_ID_Art = $row['Cited_ID_Art'];
					$C_Ordre = $row['Ordre'];
					$C_Nom = $row['Nom'];
					//$C_YOP = $row['YOP'];
					$C_Citing = $row['Citing'];
					
				$query1 = "SELECT * FROM `cited_papers_from2007_byca` where `Cited_ID_Art` = $C_Cited_ID_Art";
				$result1 = mysqli_query($link, $query1);
				//echo "<br/>".$query1;
				
				if($result1->num_rows>0) {
					while ($row = mysqli_fetch_assoc($result1)) {
						$y++;
						$ID_Art = $row['ID_Art'];
						$C_Publication_year = $row['Publication_year'];
						$C_Field = $row['Field'];
						$C_Subfield = $row['Subfield'];
						
						$query2 = "SELECT * FROM `addresses_ca_from1011` where `id_art` = $ID_Art";
						$result2 = mysqli_query($link, $query2);
						//echo "<br/>".$query2;
						
						if($result2->num_rows>0) {
							while ($row = mysqli_fetch_assoc($result2)) {
								$count++;
								$P_id_art = $row['id_art'];
								$P_ordre = $row['ordre'];
								$P_author_name = $row['author_name'];
								$P_YOP = $row['YOP'];
								
								if($P_id_art != null && $P_ordre != null ){
									$QUERY3 = "insert ignore into paired_links_valid (`Paper_ID`,`P_order`,`P_Author`,`P_year`,`Cited_paper_ID`,`C_order`,`C_Author`,`C_year`,`C_Field`,`C_Subfield`,`Citing`,`Count`) ".
																"Values($P_id_art,$P_ordre,\"$P_author_name\",$P_YOP,$C_Cited_ID_Art,$C_Ordre,\"$C_Nom\",$C_Publication_year,\"$C_Field\",\"$C_Subfield\",$C_Citing,$count)";
									mysqli_query($link, "SET CHARACTER SET 'utf8'");
									mysqli_query($link, $QUERY3);$m++;
									//echo "<br/>".$count;
								}else {
									echo "<br/> didn't find". $P_id_art . " = " .$P_ordre;
								}
								
							}
						}							
					}
					
				}
				//echo " <br/>". $C_Cited_ID_Art . " Main = " . $m ." Found in  cited_papers_from2007_byca = " . $y . " Found in addresses_ca_from1011 "  . $count;
				$count = 0; $y=0;
					
			}
			
		}
		echo "<br/> $y=".$y;
		echo "<br/> $m=".$m;
		echo "<br/> $count=".$count;
		echo "i am done";

?>