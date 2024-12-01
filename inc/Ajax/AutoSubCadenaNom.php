<?php
include("../config.inc.php");

$texto = (isset($_POST['subcadena']))? $_POST['subcadena'] :'';
$cadenaID = (isset($_POST['cadenaID']))? $_POST['cadenaID'] :'';

if ($texto != '') {
	$texto = utf8_decode($texto);
	$sql = "CALL `redefectiva`.`SP_FILTER_SUBCADENAS`('$texto', $cadenaID);";
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
			
			/*array_push($result, array( "id" => "0-0", "label" => "Unipuntos", "value" => "Unipuntos",
			"idSubCadena" => "0-0", "nombre" => "Unipuntos" ));*/
					
            foreach($items2 as $value){
				if ( $value['idSubCadena'] > 0 ) {
					if ( !preg_match('!!u', $value['nombreSubCadena']) ) {
						//no es utf-8
						$value['nombreSubCadena'] = utf8_encode($value['nombreSubCadena']);
					}
					array_push($result, array("id"=> $value['idSubCadena']."-0", "label"=> $value['nombreSubCadena'], "value" => $value['nombreSubCadena'],
					"idSubCadena" => $value['idSubCadena']."-0", "nombre" => $value['nombreSubCadena']));
				}
            }
        } else {
			/*$result = array();
			array_push($result, array( "id" => "0-0", "label" => "Unipuntos", "value" => "Unipuntos",
			"idSubCadena" => "0-0", "nombre" => "Unipuntos" ));*/		
		}
    }else{
        echo "Error al Realizar La Consulta: ".$RBD->error();
    }
	$sql = "CALL `prealta`.`SP_FILTER_PRESUBCADENAS`('$texto', $cadenaID);";
    $res = $RBD->SP($sql);
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
				if ( !preg_match('!!u', $value['nombre']) ) {
					//no es utf-8
					$value['nombre'] = utf8_encode($value['nombre']);
				}
                array_push($result, array("id"=> $value['idPreClave']."-1", "label"=> $value['nombre'], "value" => $value['nombre'],
				"idSubCadena" => $value['idPreClave']."-1", "nombre" => $value['nombre']));
            }			
		}
	}	
    echo json_encode($result);
}
?>