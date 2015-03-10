

<?php

require 'database.php';

$sql    = 'SELECT institute,ville, province,country FROM lonlat';
$result = mysqli_query($link, $sql);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}

    $i=1;
    while ($row = mysqli_fetch_assoc($result)) {
        if($i<200){
            // echo $row['institution'].' '.$row['ville'].'<br/>';
            //echo $i;
            insert($i,$row['institute'],$row['ville'],$row['province'],$row['country']);
            $i++;
        }else{
            break;
        }
    }

    mysqli_free_result($result);
        function insert($i,$institute, $ville, $province,$country)
        {
            $institute = trim($institute);
            $ville = trim($ville);
            $province = trim($province);
            $country = trim($country);

            $institute = str_replace(' ', '+', $institute);
            $ville = str_replace(' ', '+', $ville);
            $province = str_replace(' ', '+', $province);
            $country = str_replace(' ', '+', $country);
            $institute = preg_replace("[^A-Za-z0-9]", '+', $institute); //remove non alpha numeric chars such as extra spaces.
            $address_str = $institute . ',+' . $ville . ',+' . $province . '+' . $country."||";
            echo $address_str;

        }
    ?>
