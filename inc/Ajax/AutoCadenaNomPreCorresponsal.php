<?php
include("../config.inc.php");

$texto = (isset($_POST['cadena']))? $_POST['cadena'] :'';

if ($texto != '') {
	$texto = utf8_decode($texto);
	$sql = "CALL `redefectiva`.`SP_FIND_CADENAS`('$texto');";
    $res = $RBD->SP($sql);
	$result = array();
    if($RBD-> error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
            $items2 = array();
			$result2 = array();
            while($r =  mysqli_fetch_assoc($res)){
                $items2[] = $r;
            }
			while($r2 =  mysqli_fetch_array($res)){
             	$result2[$r2[0]] = $r2[1]; 
            }
					
            foreach($items2 as $value){
				if ( !preg_match('!!u', $value['nombreCadena']) ) {
					//no es utf-8
					$value['nombreCadena'] = utf8_encode($value['nombreCadena']);
				}
                array_push($result, array("id"=> $value['idCadena'], "label"=> $value['nombreCadena'], "value" => $value['nombreCadena'],
				'idCadena' => $value['idCadena'], 'nombre' => $value['nombreCadena'], 'idGrupo' => $value['idGrupo']));
            }
        }
    }else{
        echo "Error al Realizar La Consulta: ".$RBD->error();
    }	
    echo json_encode($result);
}
?>