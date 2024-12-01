<?php
include("../../config.inc.php");

$texto = (isset($_GET['term']))?strtolower($_GET['term']):'';

if ($texto != ''){
    $sql = "SELECT `idCadena`,`nombreCadena` FROM `redefectiva`.`dat_cadena` WHERE `idEstatusCadena` = 0 AND `nombreCadena` LIKE '%$texto%' LIMIT 0,20;";
    $res = $RBD->query($sql);
    if($RBD-> error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
            $items2 = array();
            $result = array();
			$result2 = array();
            while($r =  mysqli_fetch_assoc($res)){
                $items2[] = $r;
            }
			 while($r2 =  mysqli_fetch_array($res)){
             	$result2[$r2[0]] = $r2[1]; 
            }
            foreach($items2 as $value){
                //$result[$value['idCadena']] = Normalizar($value['nombreCadena']);
                array_push($result, array("id"=>$value['idCadena'], "label"=>Normalizar($value['nombreCadena']), "value" => strip_tags(Normalizar($value['nombreCadena']))));
            }
        }
    }else{
        echo "Error al Realizar La Consulta: ".$RBD->error();
    }
    echo json_encode($result);
}
?>