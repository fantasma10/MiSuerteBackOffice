<?php
include("../config.inc.php");

$texto = (isset($_GET['term']))?strtolower($_GET['term']):'';

if ($texto != ''){
	//$texto = (!preg_match('!!u', $texto))? utf8_decode($texto) : $texto;
    $texto = utf8_decode($texto);
    $sql = "CALL `redefectiva`.`SP_FIND_CALLE`('$texto');";
    $res = $RBD->SP($sql);
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
                array_push($result,
                    array(
                        "id"    =>  $value['idDireccion'],
                        "label" =>  (!preg_match('!!u', $value['calleDireccion']))? utf8_encode($value['calleDireccion']) : $value['calleDireccion'],
                        "value" =>  strip_tags((!preg_match('!!u', $value['calleDireccion']))? utf8_encode($value['calleDireccion']) : $value['calleDireccion'])
                    )
                );
            }
        }
    }else{
        echo "Error al Realizar La Consulta: ".$RBD->error();
    }
    echo json_encode($result);
}
?>