<?php
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");

	$idCadena = isset($_POST['idCadena'])? $_POST['idCadena'] : NULL;
	$idSubCadena = isset($_POST['idSubCadena'])? $_POST['idSubCadena'] : NULL;
	
	if ( isset($idCadena) && isset($idSubCadena) ) {
		$result = $RBD->SP("CALL `redefectiva`.`SP_LOAD_CORRESPONSALES`($idCadena, $idSubCadena);");
		if ( !$RBD->error() ) {
			if ( mysqli_num_rows($result) > 0 ) {
				$idCorresponsal = array();
				$nombreCorresponsal = array();
				while ( $corresponsal = mysqli_fetch_array($result) ) {
					$idCorresponsal[] = $corresponsal[0];
					$nombreCorresponsal[] = htmlentities($corresponsal[1]);
				}
				echo json_encode( array( "codigoDeRespuesta" => 0, "mensajeDeRespuesta" => "Consulta exitosa",
				"id" => $idCorresponsal, "nombre" => $nombreCorresponsal ) );
			} else {
				echo json_encode( array( "codigoDeRespuesta" => 1, "mensajeDeRespuesta" => "No se encontraron corresponsales" ) );
			}
		} else {
			echo json_encode( array( "codigoDeRespuesta" => 2, "mensajeDeRespuesta" => "No se pudo consultar la base de datos: ".$RBD->error() ) );
		}
	}
?>
