<?php
	include("../../inc/config.inc.php");
	include("../../inc/session.ajax.inc.php");
	
	$idCadena = isset($_POST['idCadena'])? $_POST['idCadena'] : NULL;
	
	if ( isset($idCadena) ) {
	
		$SQL = "CALL `redefectiva`.`SP_LOAD_SUBCADENAS`($idCadena);";
		$result = $RBD->SP($SQL);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				$subcadenas = array();
				while ( $row = $result->fetch_array() ) {
					array_push($subcadenas, array( "id" => $row[1], "nombre" => utf8_encode($row[2]) ));	
				}
				array_push($subcadenas, array( "codigoRespuesta" => 0, "descripcionRespuesta" => "Consulta exitosa" ));
				echo json_encode($subcadenas);
			} else {
				echo json_encode( array( "codigoRespuesta" => -100, "descripcionRespuesta" => "No se encontraron resultados"  ) );
			}
		} else {
			echo json_encode( array( "codigoRespuesta" => -200, "descripcionRespuesta" => "ERROR: No se pudo consultar base de datos" ) );
		}
	
	} else {
		
		echo json_encode( array( "codigoRespuesta" => -500, "descripcionRespuesta" => "ERROR: Cadena invalida" ) );
		
	}
	
?>