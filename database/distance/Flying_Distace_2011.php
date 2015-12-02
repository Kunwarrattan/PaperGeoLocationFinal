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


$query1 = 'SELECT * FROM `paired_links_valid` WHERE `DistanceID` is null';
$result1 = mysqli_query($link, $query1);
	if($result1->num_rows>0) {
		while ($row = mysqli_fetch_assoc($result1)) {
			$Paper_ID = $row['Paper_ID'];
			$P_order = $row['P_order'];
			$Cited_paper_ID = $row['Cited_paper_ID'];
			$C_order = $row['C_order'];
			
			$P_latlongID = null;
			
			// Getting the paper pipeline
			$query2 = "Select `latlongID` from `addresses_ca` where `id_art` = $Paper_ID and `ordre` = $P_order";
		   // echo "<br/>".$query2;
			$result2 = mysqli_query($link, $query2);
			if($result2->num_rows>0) {
				while ($row = mysqli_fetch_assoc($result2)) {
					$P_latlongID = $row['latlongID'];
					break;
				}
			}
			
			$C_latlongID = null;
			
			// Getting the Cited_paper pipeline
			$query3 = "Select `latlongID` from `cited_papers_addresses` where `Cited_ID_Art` = $Cited_paper_ID and `ordre` = $C_order ";
			//$query3 = "Select `latlongID` from `addresses_noca` where `id_art` = $Cited_paper_ID and `ordre` = $C_order ";
			$result3 = mysqli_query($link, $query3);
			//echo "<br/>".$query3;
			if($result3->num_rows>0) {
				while ($row = mysqli_fetch_assoc($result3)) {
					$C_latlongID = $row['latlongID'];
					break;
				}
			}
			echo "<br/>".$P_latlongID . " -  " . $C_latlongID;
			if(!$P_latlongID == null and !$C_latlongID == null){
			
			$P_lng = null;
			$P_lat = null;
			$P_city = null;
			$P_province = null;
			$P_country = null;
			$P_continent = null;	
			//Finding Lat Long 
			$query4 = "Select * from `final_addresses` where `id` = $P_latlongID ";
			$result4 = mysqli_query($link, $query4);
			//echo "<br/>".$query4;
			if($result4->num_rows>0) {
				while ($row = mysqli_fetch_assoc($result4)) {
					$P_lng = $row['lng'];
					$P_lat = $row['lat'];
					$P_city = $row['city'];
					$P_province = $row['province'];
					$P_country = $row['country'];
					$P_continent = $row['continent'];
					break;
				}
			}
			
			$C_lng = null;
			$C_lat = null;
			$C_city = null;
			$C_province = null;
			$C_country = null;
			$C_continent = null;	
			//Finding Lat Long 
			$query5 = "Select * from `final_addresses` where `id` = $C_latlongID ";
			//echo "<br/>".$query5;
			$result5 = mysqli_query($link, $query5);
			if($result5->num_rows>0) {
				while ($row = mysqli_fetch_assoc($result5)) {
					$C_lng = $row['lng'];
					$C_lat = $row['lat'];
					$C_city = $row['city'];
					$C_province = $row['province'];
					$C_country = $row['country'];
					$C_continent = $row['continent'];
				}
			}
			if($P_city == $C_city){
			$category = 1;
			//$cat = "Same City";

			}else if($P_province == $C_province){
				$category = 2;
				//$cat = "Same Province";

			} else if($P_country == $C_country){
				$category = 3;
				//$cat = "Same Country";

			}else if($P_continent == $C_continent){
				$category = 4;
				//$cat = "Same Continent";
			}else{
				$category = 5;
				//$cat = "Different Continent";
			}
			
			
			$FlyingDistance = distance($P_lat, $P_lng, $C_lat, $C_lng, "K"); //Distance in kilometers
			$time = timeCal($FlyingDistance);   // Time in minutes
			$FlyingTime  = display($time);      // Time Format in DD:HH:MM
			
			
			$queryFinal = "INSERT INTO `distance` (`lat1`,`lng1`,`lat2`,`lng2`,  `Flying_Distance`,`Flying_Time`,`Category`) VALUES ($P_lat, $P_lng, $C_lat, $C_lng,$FlyingDistance,\"$FlyingTime\",$category)";
			$result = mysqli_query($link, $queryFinal);
			//echo "<br/>".$queryFinal;
			$idN = mysqli_insert_id($link);
			
			
			//$query21 = null;
			if($idN == null){
					$query21 = "SELECT `serial` FROM `distance` where `lat1`= $P_lat AND `lng1` = $P_lng AND `lat2` = $C_lat AND `lng2` = $C_lng";
					$result21 = mysqli_query($link, $query21);
					//echo "<br/>".$query21; 
					while ($row = mysqli_fetch_assoc($result21)) {
						$idN  = $row['serial'];
				}
			}else{
				$queryFinal2 = "INSERT INTO `distance` (`lat2`,`lng2`,`lat1`,`lng1`,  `Flying_Distance`,`Flying_Time`,`Category`) VALUES  ($P_lat, $P_lng, $C_lat, $C_lng,$FlyingDistance,\"$FlyingTime\",$category)";
				$result = mysqli_query($link, $queryFinal2);
			}
			
			$queryUpdateL ="\n UPDATE `paired_links_valid` set `DistanceID` = $idN WHERE `Paper_ID` = $Paper_ID AND `P_order` = $P_order AND `Cited_paper_ID`  = $Cited_paper_ID  AND `C_order` = $C_order ";
			$result8 = mysqli_query($link, $queryUpdateL);
			echo "<br/>".$queryUpdateL;	
			}
		}
	}
	
	
function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function display($seconds) {
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}

function timeCal($distance){
     $speed = 885;           //747 Jumbo Jet assumption http://hypertextbook.com/facts/2002/JobyJosekutty.shtml
     $time = ($distance/$speed);
     return $time*60;
}	
?>