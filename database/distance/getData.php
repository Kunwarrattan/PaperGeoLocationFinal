<?php
header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!$link = mysqli_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysqli_select_db($link,'geotest')) {
    echo 'Could not select database';
    exit;
}

$data = array();
$i=1;
$index = $_GET['index']-1;

if($index >= 1 || $index < 10)
{    //exit();
    $sql    = 'SELECT `id`,`lat1`,`lng1`,`lat2`,`lng2` FROM `distance` where `DrivingDistance`  is NULL Limit '.($index*1).", 8 ";// where `DrivingDistance`  is NULL  and `Country` = "Canada
}else{
    exit();
}
$result = mysqli_query($link, $sql);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysqli_error($link);
    //exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    if ($i >= 0){
        $temp = insert($row['id'],$row['lat1'], $row['lng1'], $row['lat2'], $row['lng2']);
        $data[] = $temp;
    }
    $i++;

}

mysqli_free_result($result);
function insert($i,$lat1, $lng1, $lat2,$lng2)
{

    return array(
        "count" => $i,
        "lat1" => $lat1,
        "lng1" => $lng1,
        "lat2" => $lat2,
        "lng2" => $lng2
    );
}
echo json_encode($data);
?>
