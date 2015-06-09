<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/19/2015
 * Time: 8:30 PM
 */

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
require '../database.php';
$data = array();
$i=1;
$index = $_GET['index']-1;
echo "i m in";
if($index >= 5 && $index < 100)
{    //exit();
    $sql    = 'SELECT `id`,`lat`,`long` FROM `final_addresses2` where `city` = "" and `province` = "" and `country` = "" Limit '.($index*1).",5 ";
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
        $temp = insert($row['id'], $row['lat'], $row['long']);

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
        "long" => $long,

    );
}
echo json_encode($data);

?>
