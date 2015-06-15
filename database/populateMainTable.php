<?php
/**
 * Created by PhpStorm.
 * User: india
 * Date: 5/4/2015
 * Time: 4:24 PM
 */

require 'database.php';

$addFID = null;
$addCFID = null;
$missespaper = 0;
$missesCitedAuthor = 0;
$total = 0;
$t1=0;
$t2= 0;

//&myfile = fopen("store.txt", "rw") or die("Can't open file");

for($index=4650000;$index<4670000;$index=$index+100){
	
    $sql1 = 'select `ID_Art`, `Cited_ID_Art`, `Publication_year` from `cited_papers` Limit '.($index*1).", 100 ";
    $result1 = mysqli_query($link, $sql1);

    if (!$result1) {
        echo "\nDB Error, could not query the database Cited_Papers\n";
        echo 'MySQL Error: ' . mysqli_error($link);
        exit;
    }

    // Result of first Query from cited papers
    if($result1->num_rows>0) {

        while ($row = mysqli_fetch_assoc($result1)) {
            $addFID = $row['ID_Art'];
            $addCFID = $row['Cited_ID_Art'];
            $pyear1 = $row['Publication_year'];
			$total++;
            echo "<br /> " . $addFID . " = " . $addCFID;
            $i = 1;
            //$sql_year = " SELECT `Pyear` FROM `authors`  where `ID_Art` = $addCFID and ";


            $sql3 = "SELECT `Nom`,`Pyear`, `ordre` FROM `authors` where `id_art`= $addFID ";
            $result3 = mysqli_query($link, $sql3);


            if ($result3->num_rows > 0) {
				$missespaper++;
				$io= 0;
                while ($row = mysqli_fetch_assoc($result3)) {
                    $nom = $row['Nom'];
                    $pyear = $row['Pyear'];
                    $order = $row['ordre'];
                    //$order1 = $row['ordre'];


                    $sql5 = "SELECT `Nom`,`ordre` FROM `cited_papers_authors` where `Cited_ID_Art`= $addCFID ";
                    $result5 = mysqli_query($link, $sql5);

                    if ($result5->num_rows > 0) {
						$io = 1;
                        while ($row = mysqli_fetch_assoc($result5)) {
                            
							$nom1 = $row['Nom'];
                            $order1 = $row['ordre'];
                            $query6 = "INSERT INTO `main_database`( `Paper_ID`, `P_order`, `P_Author`, `P_year`, `Cited_paper_ID`, `C_order`, `C_Author`, `C_year`, `Count`)" .
                                "VALUES ($addFID,$order,\"$nom\",$pyear,$addCFID,$order1,\"$nom1\",$pyear1,$i)";

                            mysqli_query($link, "SET CHARACTER SET 'utf8'");
                            mysqli_query($link, $query6);
                            $i++;
                            echo "<br />" . $query6;

                        }
                    }else{
                        $missesCitedAuthor++;
                    }
                }
				if($io=1){
					$missesCitedAuthor++;
				}
            }else{
                $missespaper++;
				echo "-------------------------------------------------------------";
            }
        }
    }

}
$t1 = $total - $missespaper;
$t2 =$total - $missesCitedAuthor;
echo "<br /> Paper author Missed = ".$t1;
echo "<br /> Cited Paper author Missed = ".$t2;