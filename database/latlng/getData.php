
<?php

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);


if (!$link = mysqli_connect('localhost', 'root', '')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysqli_select_db($link,'geotest')) {
    echo 'Could not select database';
    exit;
}

mysql_query("SET NAMES 'utf8'");

$data = array();
$i=1;
$index = $_GET['index']-1;
if($index >= 0 && $index < 15)
{    //exit();
    $sql    = 'SELECT `id`,`lat`,`lng` FROM `final_addresses` where `city` = "" and `province` = "" and `country` = "" Limit '.($index*1).",5 ";
}else{
    exit();
}

$result = mysqli_query($link, $sql);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysqli_error($link);
}

while ($row = mysqli_fetch_assoc($result)) {
    if ($i >= 0){
        $temp = insert($row['id'], $row['lat'], $row['lng']);
        $data[] = $temp;
    }
    $i++;
}

mysqli_free_result($result);

function insert($i,$lat,$long)
{
    return array(
        "count" => $i,
        "lat" => $lat,
        "long" => $long
    );
}
echo json_encode($data);

