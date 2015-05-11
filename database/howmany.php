<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/11/2015
 * Time: 5:58 PM
 */

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
require 'database.php';
$p = 1;
$query2 = 'SELECT `Cited_ID_Art` FROM `cited_paper` ';
$result2 = mysqli_query($link, $query2);
//echo $result2->num_rows."<br/>";
if($result2->num_rows>0){
    while ($row = mysqli_fetch_assoc($result2)) {
        $k = $row['Cited_ID_Art'];

        $query3 = "SELECT `id_art` FROM `papers` where `id_art` = $k ";
        $result3 = mysqli_query($link, $query3);
        if($result3->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result3)) {
                $p++;
                break;

            }
        }

    }
}
echo $p;