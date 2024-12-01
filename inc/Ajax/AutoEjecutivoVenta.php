<?php
include("../config.inc.php");

$texto = (isset($_GET['term']))?strtolower($_GET['term']):'';

if ($texto != ''){
	$sql = "CALL `redefectiva`.`SP_LOAD_EJECUTIVOS`(2, '$texto');";
    $res = $RBD->SP($sql);
    if($RBD-> error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
			$ejecutivos = array();
			while ( $ejecutivo = $res->fetch_assoc() ) { 
				if ( !preg_match('!!u', $ejecutivo['nombre']) ) {
					//el string no es utf-8
					$ejecutivo['nombre'] = utf8_encode($ejecutivo['nombre']);
				}
				if ( !preg_match('!!u', $ejecutivo['apellidoPaterno']) ) {
					//el string no es utf-8
					$ejecutivo['apellidoPaterno'] = utf8_encode($ejecutivo['apellidoPaterno']);
				}
				if ( !preg_match('!!u', $ejecutivo['apellidoMaterno']) ) {
					//el string no es utf-8
					$ejecutivo['apellidoMaterno'] = utf8_encode($ejecutivo['apellidoMaterno']);
				}								
				array_push($ejecutivos, array("id"=>$ejecutivo['idUsuario'], "label"=> $ejecutivo['nombre']." ".$ejecutivo['apellidoPaterno']." ".$ejecutivo['apellidoMaterno'], "value" => $ejecutivo['nombre']." ".$ejecutivo['apellidoPaterno']." ".$ejecutivo['apellidoMaterno']));
			}
        }
    }else{
        echo "Error al Realizar La Consulta: ".$RBD->error();
    }
    echo json_encode($ejecutivos);
}
?>