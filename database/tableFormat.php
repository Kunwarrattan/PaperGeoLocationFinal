<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 4/22/2015
 * Time: 8:44 PM
 */

require 'database.php';

$query = 'SELECT `Cited_ID_Art`, `fID_Art` ,`Publication_year` FROM `cited_paper` ';  #where `latlongid` is NULL Limit '.($index*1).", 50 ";
echo $query;
echo "<br/>";
$result = mysqli_query($link, $query);
//echo $result2->num_rows;
    if($result->num_rows>0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cited_paper_id = $row['Cited_ID_Art'];
            $paper_ID = $row['fID_Art'];
            $publication_year = $row['Publication_year'];

            $paperid = null;
            $publicationyear = null;

            $query1 = "SELECT `Publication_year` FROM `papers` where  `id_art` = $paper_ID";
            $result1 = mysqli_query($link, $query1);
            if ($result1->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result1)) {
                    $publicationyear = $row['Publication_year'];
                }
            }
            $order = null;
            $Prenom = null;
            $NomFamilies = null;
            $Surnom = null;
            $str = null;
            $query2 = "SELECT * FROM `author` where  `id_art` = $paper_ID";
            echo $query2;
            echo "<br/>";
            $result2 = mysqli_query($link, $query2);
            if ($result2->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    $order = $row['Ordre'];
                    $Prenom = $row['Prenom'];
                    $NomFamilies = $row['Nom_Famille'];
                    $Surnom = $row['Surnom'];
                    $pnAME = null;
                    if($Prenom == "" && $NomFamilies == ""){
                        $pnAME = $row['Nom'];
                    }else{
                        $pnAME = $Prenom . " " . $NomFamilies . " " . $Surnom;
                    }
                    echo $pnAME;
                    echo "<br/>";
                    $query6 = "INSERT INTO `nanotech`( `paperID`,`CitedPaperID`, `ordre`, `YOP`,`PName`) VALUES ($paper_ID,$cited_paper_id ,$order,$publication_year,\"$pnAME\")";
                    echo $query6;
                    echo "<br/>";
                    mysqli_set_charset($link, "utf8");
                    mysqli_query($link, "SET NAMES 'utf8'");
                    mysqli_query($link, "SET CHARACTER SET 'utf8'");
                    mysqli_query($link, $query6);
                }
            }

            $corder = null;
            $cPrenom = null;
            $cNomFamilies = null;
            $cSurnom = null;

            $query3 = "SELECT * FROM `cited_paper_author` where  `Cited_ID_Art` = $cited_paper_id";
            echo $query3;
            echo "<br/>";
            $result3 = mysqli_query($link, $query3);
            if ($result3->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result3)) {
                    $corder = $row['Ordre'];
                    $cPrenom = $row['Prenom'];
                    $cNomFamilies = $row['Nom_Famille'];
                    $cSurnom = $row['Surnom'];

                    $cname = null;
                    if($cPrenom == "" && $cNomFamilies == ""){
                        $cname = $row['Nom'];
                    }else{
                        $cname = $cPrenom + " " + $cNomFamilies + " " + $cSurnom;
                    }


                    $queryUpdate = "UPDATE `nanotech` set `corder` = $corder and `CName` = \"$cname\" and `cYOP` = $publicationyear WHERE `CitedPaperID` = $cited_paper_id and `paperID` = $paper_ID";
                    echo $queryUpdate;
                    echo "<br/>";
                    mysqli_set_charset($link, "utf8");
                    mysqli_query($link, "SET NAMES 'utf8'");
                    mysqli_query($link, "SET CHARACTER SET 'utf8'");
                    $result9 = mysqli_query($link, $queryUpdate);

                }
            }


        }
    }