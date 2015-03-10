<?php
$lat = $_REQUEST['lat'];
$lng = $_REQUEST['lng'];
$addressnew = $_REQUEST['addressnew'];
$addressold = $_REQUEST['addressold'];

echo $lat;
print_r($_REQUEST);


require 'database.php';
// INSERT INTO `final_addresses`(`lat`, `long`, `full_address`) VALUES ('12.49494290000007','55.763516','2800 Lyngby Denmark')

$query = "INSERT INTO `final_addresses`(`lat`, `long`, `full_address`) VALUES ('$lat','$lng','$addressnew')";
echo $query;
$result = mysqli_query($link, $query);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}

?>