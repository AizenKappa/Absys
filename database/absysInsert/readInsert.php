<?php
function getId($value, $array,string $col_name){
    foreach($array as $el){
        if($el[$col_name] == $value){
            return $el["id"];
        }
    }
}
/*               ------------------------------APPENDE EXCEK FILES-----------------------------                 */
if (($open = fopen("./csv/base.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($open, 5000, ",")) !== FALSE) {
        $array[] = $data;
    }
    fclose($open);
}
if (($open = fopen("./csv/avant.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($open, 5000, ",")) !== FALSE) {
        $array_p[] = $data;
    }
    fclose($open);
}

/*                                            --------->>>>---------                                           */


/*--------------------------------------------------------------------------------------------------------------*/
/*            ----------------------------------FILIERES TABLE------------------------------------              */

$filieres = [];
$exFil=[];/* filiere that has been adde to $filiere */
$i=1;
foreach ($array as $e) {
 
    if (!in_array($e[4],$exFil)
     && preg_match('/EL HANK/', $e[2])) {
        array_push($filieres, [
            "id" =>$i++,
            "code_fil" => $e[4],
            "nom_fil" => $e[5],
        ]);
        array_push($exFil,$e[4]);
    }
}
// echo "<pre>";
// print_r($filiere);
// echo "<pre>";



$txt = "INSERT INTO `filieres` (`code_fil`, `nom_fil`) VALUES \n\t\t";
// echo "<pre>";
// print_r($filiere);
// echo "<pre>";


$lenfil = count($filieres);
$x = 1;
foreach ($filieres as $fil){
    $code_fil = $fil["code_fil"];
    $nom_fil = $fil["nom_fil"];
    if($x == $lenfil){
        $txt .= "(\"$code_fil\",\"$nom_fil\");\n";
        break;
    }
    $txt .= "(\"$code_fil\",\"$nom_fil\"),\n\t\t";

    $x++;
}

// print($txt);

// /*--------------------------------------------------------------------------------------------------------------*/
// /*            ----------------------------------GROUPES TABLE------------------------------------              */
$groupes = [];
$nom_grList = [];
$i=1;
foreach ($array as $e) {
    $nom_gr = $e[7];
    $code_fil = $e[4];
    if (!in_array($nom_gr, $nom_grList) && 
    preg_match('/EL HANK/', $e[2]) &&
    preg_match('/\w+/',$nom_gr)
    ) {
        array_push($nom_grList,$nom_gr);
        array_push($groupes,[
            "id"=>$i++,
            "filiere_id"=>getId($code_fil,$filieres,"code_fil"),
            "nom_gr"=>$nom_gr
        ]);
    }
}


$lengroupe = count($groupes);
$x = 1;
$txt .="INSERT INTO `groupes` (`filiere_id`,`nom_gp`) VALUES \n\t\t";
foreach ($groupes as $gr){
    $nom_gr = $gr["nom_gr"];
    $filiere_id = $gr["filiere_id"];
    if($x == $lengroupe){
        $txt .= "(\"$filiere_id\",\"$nom_gr\");\n";
        break;
    }
    $txt .= "(\"$filiere_id\",\"$nom_gr\"),\n\t\t";

    $x++;
}


// /* --------------------------------------------------------------------------------------------------------------*/
// /*             ----------------------------------STAGIAIRES TABLE------------------------------------           */

// ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]');\n";
$stagiaires = [];
$mtr = [];
foreach ($array as $e) {
    if (!in_array($e[9], $mtr) && preg_match('/EL HANK/', $e[2]) && preg_match('/oui/', strtolower($e[10])) 
    && in_array($e[7], $nom_grList) ) {
        array_push($stagiaires, [
            
            "nom_st" => $e[15],
            "prenom_st" => $e[16],
            "groupe_id" => getId($e[7],$groupes,"nom_gr") ,
            "numero_personnelle" => $e[22],
        ]);
        array_push($mtr, $e[9]);
    }
}

$lenst = count($stagiaires);
$x = 1;
$txt .= "INSERT INTO `stagiaires` (`nom_st`, `prenom_st`, `groupe_id`,`numero_personnelle`) VALUES \n\t\t"; 
foreach ($stagiaires as $st){
    $nom_st = $st["nom_st"];
    $prenom_st = $st["prenom_st"];
    $groupe_id = $st["groupe_id"];
    $numero_personnelle = $st["numero_personnelle"];
    if($x == $lenst){
        $txt .= "(\"$nom_st\",\"$prenom_st\",\"$groupe_id\",\"$numero_personnelle\");\n";
        break;
    }
    $txt .= "(\"$nom_st\",\"$prenom_st\",\"$groupe_id\",\"$numero_personnelle\"),\n\t\t";

    $x++;
}


// /* --------------------------------------------------------------------------------------------------------------*/
// /*             ----------------------------------FORMATEURS TABLE------------------------------------           */
// $sql = "INSERT INTO profs(code_prof,nom_prof) VALUES (?,?)";

$profs = [];
$id_fm = [];
$i=1;
foreach (array_slice($array_p,1) as $e) {
    $test = preg_match('/[\s\w]{2,}/', $e[19]) && preg_match('/[\s\w]{2,}/',$e[20]);
    if(!in_array($e[19],$id_fm) && $test){
        array_push($id_fm,$e[19]);
        array_push($profs, [
            "id" => $i++,
            "id_tch"=>$e[19],
            "nom_prof" => $e[20],
        ]);
    }
   
    
}

// echo "<pre>";
// print_r($profs);
// echo "<pre>";
// exit(0);


$lenform = count($profs);
$x = 1;
$txt .="INSERT INTO `profs`(`nom_prof`) VALUES \n\t\t";/* ('[value-1]','[value-2]') */
foreach ($profs as $for){
  
    $nom_prof = $for["nom_prof"];
    if($x == $lenform){
        $txt .= "(\"$nom_prof\");\n";
        break;
    }
    $txt .= "(\"$nom_prof\"),\n\t\t";

    $x++;
}



// /* --------------------------------------------------------------------------------------------------------------*/
// /*             ----------------------------------FORMTEURS/GROUPES------------------------------------           */
// $sql = "INSERT INTO relations(prof_id,groupe_id) VALUES (?,?)";
/* e[8] =>nom_gr , e[19] => id_tch */
$relations = [];
$id_rel = [];
foreach (array_slice($array_p,1) as $e) {
    $arrRel = [
        "prof_id" =>getId($e[19],$profs,"id_tch") ,
        "groupe_id" => getId($e[8],$groupes,"nom_gr")
    ];
    $test = preg_match('/[\s\w]{2,}/', $e[8]) && preg_match('/[\s\w]{2,}/',$e[19]);
    if(!in_array($arrRel,$relations) && $test){
        array_push($relations,$arrRel);
    }
    
}

$lenrel = count($relations);
$x = 1;
$txt .="INSERT INTO `relations`(`prof_id`, `groupe_id`) VALUES \n\t\t";
foreach ($relations as $rel){
    $prof_id = $rel["prof_id"];
    $groupe_id = $rel["groupe_id"];
    if($x == $lenrel){
        $txt .= "(\"$prof_id\",\"$groupe_id\");\n";
        break;
    }
    $txt .= "(\"$prof_id\",\"$groupe_id\"),\n\t\t";

    $x++;
}

$insertFile = fopen("./sql/insertFile.sql","w");
fwrite($insertFile,$txt);
echo "this is done";
exit(0);
/* $conn->query("CREATE DATABASE absys"); */

if($conn->multi_query($command) != True){
    echo "Error: ";
}
// /*------------------------------------------------Succecc--------------------------------------------------------*/
// echo "<script>alert('Success');</script>";
