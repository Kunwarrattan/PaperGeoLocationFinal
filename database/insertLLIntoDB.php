<?php
set_time_limit(0);
$lati = null;
$lng = null;
$addressnew  = null;
$addressold = null;
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


print_r($_REQUEST);


require 'database.php';
// INSERT INTO `final_addresses`(`lat`, `long`, `full_address`) VALUES ('12.49494290000007','55.763516','2800 Lyngby Denmark')
if($lng!= null && $lng != null){
$query = "INSERT IGNORE INTO `final_addresses`( `lat`, `long`, `full_address`) VALUES ($lati,$lng,\"$addressnew\")";
//echo $query;
$result = mysqli_query($link, $query);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}
}
?>