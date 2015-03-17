<?php
set_time_limit(0);
require 'database.php';
$data = array();
    $i=1;
$index = $_GET['index']-1;

if($index >= 1840 || $index < 1834)
{    //exit();
$sql    = 'SELECT id,institute,ville, province,country FROM address_unique Limit '.($index*10).", 10";
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
            $temp = insert($row['id'], $row['institute'], $row['ville'], $row['province'], $row['country']);
            $data[] = $temp;
        }
        $i++;

    }

    mysqli_free_result($result);
        function insert($i,$institute, $ville, $province,$country)
        {
            $institute = trim($institute);
            $ville = trim($ville);
            $province = trim($province);
            $country = trim($country);

//            $institute = str_replace(' ', '+', $institute);
//            $ville = str_replace(' ', '+', $ville);
//            $province = str_replace(' ', '+', $province);
//            $country = str_replace(' ', '+', $country);
            $institute = preg_replace("[^A-Za-z0-9]", '+', $institute); //remove non alpha numeric chars such as extra spaces.
            $address_str = $institute . ',+' . $ville . ',+' . $province . '+' . $country."||";
            //echo $address_str;
           // $obj = new stdClass();

            return array(
                "count" => $i,
                "institute" => $institute,
                "ville" => $ville,
                "province" => $province,
                "country" => $country
            );
        }
        echo json_encode($data);
    ?>
