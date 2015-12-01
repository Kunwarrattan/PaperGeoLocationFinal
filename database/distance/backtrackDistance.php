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

$query2 = "select * from `paired_links_valid` where `Flying_Distance` is null";
$result2 = mysqli_query($link, $query2);
	if($result2->num_rows>0) {
		while ($row = mysqli_fetch_assoc($result2)) {
			$id =  $row['serial'];
			$distanceID = $row['DistanceID'];
			$query3 = "select * from `distance` where `serial` = $distanceID ";
			
			$result3 = mysqli_query($link, $query3);
				if($result3->num_rows>0) {
					while ($row = mysqli_fetch_assoc($result3)) {
						$FlyDis = $row['Flying_Distance'];
						$FlyTim = $row['Flying_Time'];
						$DrivDis = $row['Driving_Distance'];
						$DrivTime = $row['Driving_Time'];
						$Category = $row['Category'];
						if($DrivDis != NULL && $DrivTime != NULL){						
							$query4 =  "update `paired_links_valid` set `Flying_Distance` = $FlyDis , `Flying_Time` = \"$FlyTim\", `Driving_Distance` = $DrivDis  , `Driving_Time`= \"$DrivTime\", `Location_Category` = $Category where `serial` = $id";
							$result4 = mysqli_query($link, $query4);
							echo "<br/>".$query4;
						}else{
							$query4 =  "update `paired_links_valid` set `Flying_Distance` = $FlyDis , `Flying_Time` = \"$FlyTim\", `Location_Category` = $Category where `serial` = $id";
							$result4 = mysqli_query($link, $query4);
							echo "<br/>".$query4;
						}
					}

				}
		}
	
	}
	echo "I'm done";
	?>