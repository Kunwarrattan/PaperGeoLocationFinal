
<?php

require 'database1.php';

$lat1 = null;
$long1 = null;
$lat2 = null;
$long2 = null;
$addFID = null;
$addCFID = null;

//$myfile = fopen("FlyingDistance.txt", "a") or die("Unable to open file!");


$sql1 = "select `fID_Art`, `Cited_ID_Art`  from `cited_paper`";
$result1 = mysqli_query($link, $sql1);

//fwrite($myfile, $sql1);
//fwrite($myfile,"\n");

if (!$result1) {
    echo "\nDB Error, could not query the database Cited_Paper\n";
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}

while ($row = mysqli_fetch_assoc($result1)) {

    $addFID  = $row['fID_Art'];
    $addCFID  = $row['Cited_ID_Art'];


    $add1 = null;
    $add2 = null;

    $sql2 = "SELECT `id_art`,`latlong` FROM `addresses` where `id_art`= $addFID ";
    $result2 = mysqli_query($link, $sql2);

  //  fwrite($myfile, $sql2);
   // fwrite($myfile,"\n");

    while ($row = mysqli_fetch_assoc($result2)) {
        $add1  = $row['latlong'];
    }
    if (!$result2) {
        echo "\nDB Error, could not query the Addresses database\n";
        echo 'MySQL Error: ' . mysqli_error($link);
        //exit;
    }

    $sql3 = "SELECT `Cited_ID_Art`,`latlong` FROM `cited_paper_address` where `id_art`= $addCFID ";
    $result3 = mysqli_query($link, $sql3);

    //fwrite($myfile, $sql3);
    //fwrite($myfile,"\n");

    while ($row = mysqli_fetch_assoc($result3)) {
        $add2  = $row['latlong'];
    }
    if (!$result3) {
        echo "\nDB Error, could not query the Cited_paper_Addresses database\n";
        echo 'MySQL Error: ' . mysqli_error($link);
        //exit;
    }

    $lat1 = null;
    $lat2 = null;
    $lng1 = null;
    $lng2 = null;
    $country1=null;
    $country2=null;
    $province1=null;
    $province2=null;
    $city1=null;
    $city2=null;

    //------------------------ [categorisation for address table]  -----------------------------------------
    $sql4 = "SELECT `lat`,`long`,`city`,`province`,`country` FROM `final_addresses` where `id`= $add1 ";
    $result4 = mysqli_query($link, $sql4);

    //fwrite($myfile, $sql4);
    //fwrite($myfile,"\n");

    while ($row = mysqli_fetch_assoc($result4)) {
        $lat1  = $row['lat'];
        $lng1  = $row['long'];
        $city1 = $row['city'];
        $province1 = $row['province'];
        $country1 = $row['country'];
    }

    //------------------------ [categorisation for Cited_address_table]  -----------------------------------------
    $sql5 = "SELECT `lat`,`long`,`city`,`province`,`country` FROM `final_addresses` where `id`= $add2 ";
    $result5 = mysqli_query($link, $sql5);

    fwrite($myfile, $sql5);
    fwrite($myfile,"\n");

    while ($row = mysqli_fetch_assoc($result5)) {
        $lat2  = $row['lat'];
        $lng2  = $row['long'];
        $city2 = $row['city'];
        $province2 = $row['province'];
        $country2 = $row['country'];
    }

    $continent1 = null;
    $continent2 = null;
    //------------------------ [continent match1]  -----------------------------------------
    $country11 = "SELECT `continent` FROM `countries` where `name` = $country1 OR `native`= $country1";
    $result6 = mysqli_query($link, $country11);


    fwrite($myfile, $country11);
    fwrite($myfile,"\n");

    while ($row = mysqli_fetch_assoc($result6)) {
        $continent1  = $row['continent'];
    }
    //------------------------ [continent match2]  -----------------------------------------
    $country12 = "SELECT `continent` FROM `countries` where `name` = $country2 OR `native`= $country2";
    $result7 = mysqli_query($link, $country12);


    fwrite($myfile, $country12);
    fwrite($myfile,"\n");

    while ($row = mysqli_fetch_assoc($result7)) {
        $continent2  = $row['continent'];
    }
    $category = null;
    $cat = null;
    if($city1 == $city2){
       $category = 1;
       $cat = "Same City";

    }else if($province1 == $province2){
        $category = 2;
        $cat = "Same Province";

    } else if($country1 == $country2){
        $category = 3;
        $cat = "Same Country";

    }else if($continent1 == $continent2){
        $category = 4;
        $cat = "Same Continent";
    }else{
        $category = 5;
        $cat = "Different Continent";
    }


    $FlyingDistance = distance($lat1, $lng1, $lat2, $lng2, "K"); //Distance in kilometers
    $time = timeCal($FlyingDistance);   // Time in minutes
    $FlyingTime  = display($time);      // Time Foramt in HH:MM:SS

    $queryFinal = "INSERT INTO `distance` (`lat1`,`lng1`,`lat2`,`lng2`, `FlyingDistance`, `FlyingTime`,`Category`) VALUES ($lat1, $lng1, $lat2, $lng2,$FlyingDistance,$FlyingTime,$category)";
    $result = mysqli_query($link, $queryFinal);

    fwrite($myfile, $queryFinal);
    fwrite($myfile,"\n");

    $idN = mysqli_insert_id($link);

    $query21 = null;
    if($idN == null){
            $query21 = "SELECT `id` FROM `distance` where `lat1`= $lat1 AND `lng1` = $lng1 AND `lat2` = $lat2 AND `lng2` = $lng2";
            $result21 = mysqli_query($link, $query21);
            while ($row = mysqli_fetch_assoc($result21)) {
                $idN  = $row['id'];
        }
    }else{
        $queryFinal2 = "INSERT INTO `distance` (`lat2`,`lng2`,`lat1`,`lng1`, `FlyingDistance`, `FlyingTime`,`Category`) VALUES ($lat1, $lng1, $lat2, $lng2,$FlyingDistance,$FlyingTime,$category)";
        $result = mysqli_query($link, $queryFinal2);
    }

//need to chnage
    $queryUpdateL ="\n UPDATE `cited_paper` set `distanceID` = $idN WHERE `fID_Art` = $addFID AND   `Cited_ID_Art` = $addCFID ";
    $result1 = mysqli_query($link, $queryUpdateL);

    echo "\n Latitude1 :".$lat1." Longitude1 :".$lng1." Latitude2 :".$lat2." Longitude2 :".$lng2." ";
    echo "\n Flying Distance :".$FlyingDistance." Flying Time : ".$FlyingTime." Category: " . $cat . "  Type : ".$category;
    echo "\n -----------------------------------------------------------------------------------------------------------------------";

    fwrite($myfile, "--------------------------------------------------------------------------------------------------");
    fwrite($myfile,"\n");

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

fwrite($myfile, $txt);
fwrite($myfile,"\n");
fclose($myfile);