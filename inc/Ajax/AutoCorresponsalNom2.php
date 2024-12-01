<?php
include("../config.inc.php");

$texto = (isset($_POST['term']))?strtolower($_POST['term']):'';

if ($texto != ''){
    $sql = "CALL `redefectiva`.`SP_LOAD_CORRESPONSALES_TEXT`('$texto')";
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
                array_push($result, array("idCorresponsal"=>$value['idCorresponsal'], "nombreCorresponsal"=> utf8_encode($value['nombreCorresponsal']), "value" => utf8_encode(strip_tags($value['nombreCorresponsal']))));
            }
        }
    }else{
        echo "Error al Realizar La Consulta: ".$RBD->error();
    }
    echo json_encode($result);
}
?>