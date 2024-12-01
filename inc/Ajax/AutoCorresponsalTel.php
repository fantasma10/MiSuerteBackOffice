<?php
include("../config.inc.php");

$texto = (isset($_REQUEST['term']))?strtolower($_REQUEST['term']):'';

if ($texto != ''){
    $sql = "SELECT `idCorresponsal`, `nombreCorresponsal` FROM `redefectiva`.`dat_corresponsal` WHERE `idEstatusCorresponsal` = 0 AND `telefono1` LIKE '%$texto%';";
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
			
			
			//aki va la tabla a los contactos tmps y se unen a res
			
			
            foreach($items2 as $value){
                //$result[$value['idCadena']] = Normalizar($value['nombreCadena']);
                array_push($result, array("id"=>$value['idCorresponsal'], "label"=>Normalizar($value['nombreCorresponsal']), "value" => strip_tags(Normalizar($value['nombreCorresponsal']))));
            }
        }
    }else{
        echo "Error al Realizar La Consulta: ".$RBD->error();
    }
    echo json_encode($result);
}
?>