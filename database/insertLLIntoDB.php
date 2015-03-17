<?php
set_time_limit(0);
$lati = null;
$lng = null;
$addressnew  = null;
$addressold = null;
$id=null;

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

print_r($_REQUEST);


require 'database.php';
// INSERT INTO `final_addresses`(`lat`, `long`, `full_address`) VALUES ('12.49494290000007','55.763516','2800 Lyngby Denmark')
if($lng!= null && $lng != null){

    $query = "INSERT INTO `final_addresses`( `lat`, `long`, `full_address`) VALUES ($lati,$lng,\"$addressnew\")";
    $result = mysqli_query($link, $query);

    $idN = mysqli_insert_id($link);
   // $idOLD = null;
    $query2 = null;
    if($idN == null){
        $query2 = "SELECT `id` FROM `final_addresses` where `lat`= $lati AND `long` = $lng";
        $result2 = mysqli_query($link, $query2);
        while ($row = mysqli_fetch_assoc($result2)) {
            $idN  = $row['id'];
    }
    }


    $queryUpdate ="\n UPDATE `address_unique` set `latlongid` = $idN WHERE `id` = $id";
    $result1 = mysqli_query($link, $queryUpdate);
    echo $queryUpdate;


    $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
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