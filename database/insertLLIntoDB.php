<?php
header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
$lati = null;
$lng = null;
$addressnew  = null;
$addressold = null;
$id=null;
$cty = null;
$state = null;
$country = null;
$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
if(isset($_REQUEST['lat']) && $_REQUEST['lat']!="")
{
    $lati=($_REQUEST['lat']);
}
if(isset($_REQUEST['lng']) && $_REQUEST['lng']!="")
{
    $lng=($_REQUEST['lng']);
}
if(isset($_REQUEST['addressnew']) && $_REQUEST['addressnew']!="")
{
    $addressnew=($_REQUEST['addressnew']);
}

if(isset($_REQUEST['addressold']) && $_REQUEST['addressold']!="")
{
    $addressold=($_REQUEST['addressold']);
}
if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
{
    $id=($_REQUEST['id']);
}
if(isset($_REQUEST['cty']) && $_REQUEST['cty']!="")
{
    $cty=($_REQUEST['cty']);
}if(isset($_REQUEST['state']) && $_REQUEST['state']!="")
{
    $state=($_REQUEST['state']);
}if(isset($_REQUEST['country']) && $_REQUEST['country']!="")
{
    $country=($_REQUEST['country']);
}
print_r($_REQUEST);


require 'database.php';
// INSERT INTO `final_addresses`(`lat`, `long`, `full_address`) VALUES ('12.49494290000007','55.763516','2800 Lyngby Denmark')
if($lng!= null && $lng != null){

    $query = "INSERT INTO `final_addresses2`( `lat`, `long`, `full_address`,`city`,`province`,`country`) VALUES ($lati,$lng,\"$addressnew\",\"$cty\",\"$state\",\"$country\")";
	//mysqli_query("utf8",$query);
	mysqli_set_charset($link, "utf8");
	mysqli_query($link, "SET NAMES 'utf8'"); 
	mysqli_query($link, "SET CHARACTER SET 'utf8'");
    $result = mysqli_query($link, $query);

    $idN = mysqli_insert_id($link);
    fwrite($myfile, $query);
    fwrite($myfile,"\n");
   // $idOLD = null;
//    if (!$result) {
//        $queryUpdate6 = "UPDATE `final_addresses` set `city` = \"$cty\" and `province` = \"$state\" and `country` = \"$country\"WHERE `lat` = $lati and `long` = $lng";
//        $result6 = mysqli_query($link, $queryUpdate6);
//        fwrite($myfile, $queryUpdate6);
//        fwrite($myfile,"\n");
//    }

    $query2 = null;
    if($idN == null){
        $query2 = "SELECT `id` FROM `final_addresses2` where `lat`= $lati AND `long` = $lng";
        $result2 = mysqli_query($link, $query2);
        while ($row = mysqli_fetch_assoc($result2)) {
            $idN  = $row['id'];
    }
    }


    $queryUpdate ="\n UPDATE `address_unique` set `latlongid` = $idN WHERE `id` = $id";
    $result1 = mysqli_query($link, $queryUpdate);
    echo $queryUpdate;





    fwrite($myfile, $idN);
    fwrite($myfile,"\n");
    fwrite($myfile, $queryUpdate);
    fwrite($myfile,"\n");
    fwrite($myfile, $query2);
    $txt = "\n--------------------------------------------";
    fwrite($myfile, $txt);
    fwrite($myfile,"\n");
    fclose($myfile);



if (!$result) {
    echo "\n DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysqli_error($link);
    //exit;
}
}
?>