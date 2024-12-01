<?php
	include("../../inc/config.inc.php");
	include("../../inc/session.ajax.inc.php");
	
	$idCadena = isset($_POST['idCadena'])? $_POST['idCadena'] : NULL;
	$idSubcadena = isset($_POST['idSubcadena'])? $_POST['idSubcadena'] : NULL;
	
	if ( isset($idCadena) && isset($idSubcadena) ) {
	
		$SQL = "CALL `redefectiva`.`SP_LOAD_CORRESPONSALES`($idCadena, $idSubcadena);";
		$result = $RBD->SP($SQL);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				$corresponsales = array();
				while ( $row = $result->fetch_array() ) {
					array_push($corresponsales, array( "id" => $row[0], "nombre" => utf8_encode($row[1]) ));	
				}
				array_push($corresponsales, array( "codigoRespuesta" => 0, "descripcionRespuesta" => "Consulta exitosa" ));
				echo json_encode($corresponsales);
			} else {
				echo json_encode( array( "codigoRespuesta" => -100, "descripcionRespuesta" => "No se encontraron resultados"  ) );
			}
		} else {
			echo json_encode( array( "codigoRespuesta" => -200, "descripcionRespuesta" => "ERROR: No se pudo consultar base de datos" ) );
		}
	
	} else {
		
		echo json_encode( array( "codigoRespuesta" => -500, "descripcionRespuesta" => "ERROR: Cadena o Subcadena invalida" ) );
		
	}
	
?>