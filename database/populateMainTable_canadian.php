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

for($index=1;$index<1000;$index=$index+100){
	
    $sql1 = 'select `ID_Art`, `Cited_ID_Art`, `Publication_year` from `cited_papers3y` Limit '.($index*1).", 100 ";
    $result1 = mysqli_query($link, $sql1);

    if (!$result1) {
        echo "\nDB Error, could not query the database cited_papers3y_fromca\n";
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
            //echo "<br /> " . $addFID . " = " . $addCFID; 
            $i = 1;
            
            $sql3 = "SELECT `author_name`,`Node_id` ,`YOP`, `ordre` FROM `addresses_ca_from1011` where `id_art`= $addFID ";
            $result3 = mysqli_query($link, $sql3);
			echo "<br />".$sql3;
            if ($result3->num_rows > 0) {
				$missespaper++;
				$io= 0;
				echo "asd";
                while ($row = mysqli_fetch_assoc($result3)) {
                    $nom = $row['author_name'];
                    $pyear = $row['YOP'];
                    $order = $row['ordre'];
					$nodeid = $row['Node_id'];

                    $sql5 = "SELECT `Nom`,`Ordre` FROM `cited_authors` where `Cited_ID_Art`= $addCFID ";
                    $result5 = mysqli_query($link, $sql5);

					echo "<br /> hola 1";
                    if ($result5->num_rows > 0) {
						$io = 1;
                        while ($row = mysqli_fetch_assoc($result5)) {
                            
							$nom1 = $row['Nom'];
                            $order1 = $row['Ordre'];
                            $query6 = "INSERT INTO `paired_links_valid`( `Paper_ID`, `P_order`, `P_Author`, `Node_id`, `P_year`, `Cited_paper_ID`, `C_order`, `C_Author`, `C_year`, `Count`)" .
                                "VALUES ($addFID,$order,\"$nom\",$nodeid,$pyear,$addCFID,$order1,\"$nom1\",$pyear1,$i)";

                            mysqli_query($link, "SET CHARACTER SET 'utf8'");
                            mysqli_query($link, $query6);
                            $i++;
                            echo "<br />" . $query6;
							
							//echo "<br /> hola 2";

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