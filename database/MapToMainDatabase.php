<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/4/2015
 * Time: 4:24 PM
 */

require 'database1.php';

$addFID = null;
$addCFID = null;

$sql1 = 'select `fID_Art`, `Cited_ID_Art`  from `cited_paper` ';
$result1 = mysqli_query($link, $sql1);

if (!$result1) {
    echo "\nDB Error, could not query the database Cited_Paper\n";
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}

while ($row = mysqli_fetch_assoc($result1)) {
    $addFID  = $row['fID_Art'];
    $addCFID  = $row['Cited_ID_Art'];

    $add1 = null;
    $add2 = null;
    $i=1;
    //$sql_year = " SELECT `Pyear` FROM `authors`  where `ID_Art` = $addCFID and ";

    $sql2 = "SELECT `id_art`,`ordre`,`latlongID` FROM `addresses` where `id_art`= $addFID ";
    $result2 = mysqli_query($link, $sql2);
    while ($row = mysqli_fetch_assoc($result1)) {
        $order = $row['ordre'];
        $latlongID = $row['latlongID'];
        $sql3 = "SELECT `serial`,`Nom`,`Pyear` FROM `authors` where `id_art`= $addFID and `ordre` = $order ";
        $result3 = mysqli_query($link, $sql3);
        while ($row = mysqli_fetch_assoc($result3)) {
            $nom = $row['Nom'];
            $pyear = $row['Pyear'];

            //left side code

            $sql4 = "SELECT `id_art`,`ordre`,`latlongID` FROM `cited_paper_address` where `Cited_ID_Art`= $addCFID ";
            $result4 = mysqli_query($link, $sql4);
            while ($row = mysqli_fetch_assoc($result4)) {
                $order1 = $row['ordre'];
                $latlongID1 = $row['latlongID'];


                $sql5 = "SELECT `serial`,`Nom`,`Pyear` FROM `cited_paper_author` where `Cited_ID_Art`= $addCFID and `Ordre` = $order1 ";
                $result5 = mysqli_query($link, $sql5);
                while ($row = mysqli_fetch_assoc($result5)) {
                    $nom1 = $row['Nom'];
                    $pyear1 = $row['Pyear'];

                    $query6 = "INSERT INTO `main_database` (`Paper`, `P_order`, `P_Author`, `P_year`,`P_LatLongID`,".
                                   " `Cited_paper`, `C_order`, `C_Auhtor`, `C_year`, `C_LatLongID`, `Count`)".
                                    "VALUES ($addFID,$order,\"$nom\",$pyear,$latlongID,$addCFID,$order1,\"$nom1\",$pyear1,$latlongID1,$i)";
                    mysqli_query($link, "SET CHARACTER SET 'utf8'");
                    mysqli_query($link, $query6);
                    $i++;


                }

            }

        }

    }





}