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

$sql1 = 'select `fID_Art`, `Cited_ID_Art`, `Publication_year` from `cited_paper` ';
$result1 = mysqli_query($link, $sql1);

if (!$result1) {
    echo "\nDB Error, could not query the database Cited_Paper\n";
    echo 'MySQL Error: ' . mysqli_error($link);
    exit;
}
if($result1->num_rows>0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $addFID = $row['fID_Art'];
        $addCFID = $row['Cited_ID_Art'];
        $pyear1 = $row['Publication_year'];
        $i = 1;
        //$sql_year = " SELECT `Pyear` FROM `authors`  where `ID_Art` = $addCFID and ";

        $sql2 = "SELECT `id_art`,`ordre` FROM `addresses` where `id_art`= $addFID ";
        $result2 = mysqli_query($link, $sql2);

        if ($result2->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result2)) {
                $order = $row['ordre'];
                // $latlongID = $row['latlongID'];
                $sql3 = "SELECT `serial`,`Nom`,`Pyear` FROM `authors` where `id_art`= $addFID and `ordre` = $order ";
                $result3 = mysqli_query($link, $sql3);

                if ($result3->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result3)) {
                        $nom = $row['Nom'];
                        $pyear = $row['Pyear'];

                        //left side code

                        $sql4 = "SELECT `id_art`,`ordre` FROM `cited_paper_address` where `Cited_ID_Art`= $addCFID ";
                        $result4 = mysqli_query($link, $sql4);
                        if ($result4->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($result4)) {
                                $order1 = $row['ordre'];
                                // $latlongID1 = $row['latlongID'];

                                $sql5 = "SELECT `serial`,`Nom` FROM `cited_paper_author` where `Cited_ID_Art`= $addCFID and `Ordre` = $order1 ";
                                $result5 = mysqli_query($link, $sql5);

                                if ($result5->num_rows > 0) {
                                    while ($row = mysqli_fetch_assoc($result5)) {
                                        $nom1 = $row['Nom'];
                                        $query6 = "INSERT INTO `main_database` (`Paper_ID`, `P_order`, `P_Author`, `P_year`" .
                                                " `Cited_paper_ID`, `C_order`, `C_Auhtor`, `C_year`, `Count`)" .
                                                "VALUES ($addFID,$order,\"$nom\",$pyear,$addCFID,$order1,\"$nom1\",$pyear1,$i)";

                                        mysqli_query($link, "SET CHARACTER SET 'utf8'");
                                        mysqli_query($link, $query6);
                                        $i++;


                                    }

                                    }else{
                                        $query6 = "INSERT INTO `main_database` (`Paper_ID`, `P_order`, `P_Author`, `P_year`" .
                                            " `Cited_paper_ID`, `C_order`,`C_year`, `Count`)" .
                                            "VALUES ($addFID,$order,\"$nom\",$pyear,$addCFID,$order1,$pyear1,$i)";

                                        mysqli_query($link, "SET CHARACTER SET 'utf8'");
                                        mysqli_query($link, $query6);
                                        $i++;
                                    }
                                }

                            }
                        }
                }else{
                            $sql4 = "SELECT `id_art`,`ordre` FROM `cited_paper_address` where `Cited_ID_Art`= $addCFID ";
                            $result4 = mysqli_query($link, $sql4);
                            if ($result4->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($result4)) {
                                    $order1 = $row['ordre'];
                                    // $latlongID1 = $row['latlongID'];

                                    $sql5 = "SELECT `serial`,`Nom` FROM `cited_paper_author` where `Cited_ID_Art`= $addCFID and `Ordre` = $order1 ";
                                    $result5 = mysqli_query($link, $sql5);

                                    if ($result5->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($result5)) {
                                            $nom1 = $row['Nom'];
                                            $query6 = "INSERT INTO `main_database` (`Paper_ID`, `P_order`, ".
                                                " `Cited_paper_ID`, `C_order`, `C_Auhtor`, `C_year`, `Count`)" .
                                                "VALUES ($addFID,$order,$addCFID,$order1,\"$nom1\",$pyear1,$i)";

                                            mysqli_query($link, "SET CHARACTER SET 'utf8'");
                                            mysqli_query($link, $query6);
                                            $i++;


                                        }

                                    }else{
                                        $query6 = "INSERT INTO `main_database` (`Paper_ID`, `P_order`, " .
                                            " `Cited_paper_ID`, `C_order`,`C_year`, `Count`)" .
                                            "VALUES ($addFID,$order,$addCFID,$order1,$pyear1,$i)";

                                        mysqli_query($link, "SET CHARACTER SET 'utf8'");
                                        mysqli_query($link, $query6);
                                        $i++;
                                    }
                                }

                            }
                    }
                }

            }

        }


    }
}else{
    echo "Enough.......................................................<br />";
}