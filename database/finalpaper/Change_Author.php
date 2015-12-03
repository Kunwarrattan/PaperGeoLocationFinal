<?php 
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

//FOR THE CITING ONE UNCOMMENT THIS
//$query1 = 'SELECT * FROM `paired_links_valid` WHERE `Citing` = 1 and `DistanceID` is NULL';
//FOR THE NON CITING ONE UNCOMMENT THIS
$query1 = 'SELECT * FROM `paired_links_valid` WHERE `Citing` = 0 and `DistanceID` is NULL';
$result1 = mysqli_query($link, $query1);
	if($result1->num_rows>0) {
		while ($row = mysqli_fetch_assoc($result1)) {
			
			$C_Cited_paper_ID  = $row['Cited_paper_ID'];
			$C_order = $row['C_order'];
			
			$array = Array(10);
			$query2 = "SELECT * FROM `cited_papers_addresses` where `Cited_ID_Art` = $C_Cited_paper_ID ";
			
			$result2 = mysqli_query($link, $query2);
				if($result2->num_rows>0) {
					$i=0;
					while ($row = mysqli_fetch_assoc($result2)) {
						$array[$i] = $row['ordre'];
						$i++;
					}
					
				}
				$rand = array_rand($array, 1);
				$nom = null;
				$query4 = "Select * from `cited_authors_from2007_byca` where `Cited_ID_Art` = $C_Cited_paper_ID and `Ordre` =  $C_order ";
				//echo $query4;
				$result4 = mysqli_query($link, $query4);
				if($result4->num_rows>0) {
					while ($row = mysqli_fetch_assoc($result4)) {
						$nom = $row['Nom'];
					}
				}
				
				if($nom != null){
					$query3 = "update `paired_links_valid` set `C_order` = $array[$rand] and `C_Author` = \"$nom\" where `Cited_paper_ID` = $C_Cited_paper_ID and `C_order` =  $C_order ";
					//echo "<br/>".$query3;
					mysqli_query($link, "SET CHARACTER SET 'utf8'");
					$result7 = mysqli_query($link, $query3);
					$num = mysqli_affected_rows($link);
				//	echo "<br/>".$num . " array =" .count($array);
					unset($array[$rand]);
					for($i=1;$i<=count($array);$i++){
						if($num==-1 and count($array) != 0){
								$rand = array_rand($array, 1);
								$query14 = "Select * from `cited_authors_from2007_byca` where `Cited_ID_Art` = $C_Cited_paper_ID and `Ordre` =  $C_order ";
								//echo $query4;
								$result14 = mysqli_query($link, $query14);
								if($result14->num_rows>0) {
									while ($row = mysqli_fetch_assoc($result14)) {
										$nom = $row['Nom'];
											if($nom != null){
											$query13 = "update `paired_links_valid` set `C_order` = $array[$rand] and `C_Author` = \"$nom\" where `Cited_paper_ID` = $C_Cited_paper_ID and `C_order` =  $C_order ";
											echo "<br/>".$query13;
											mysqli_query($link, "SET CHARACTER SET 'utf8'");
											$result17 = mysqli_query($link, $query13);
											$num = mysqli_affected_rows($link);
											echo "<br/>". $i ." Again = ".$num;
									}
								}
							}
						}
						unset($array[$rand]);
					}	
			}
		}
	
	}
	
?>