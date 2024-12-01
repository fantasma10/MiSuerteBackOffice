<?php
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");
	
	$idNivel = !empty( $_POST['idNivel'] )? $_POST['idNivel'] : -500;
	$familias = !empty( $_POST['familias'] )? $_POST['familias'] : NULL;
	$idAfiliacion = !empty( $_POST['idAfiliacion'] )? $_POST['idAfiliacion'] : NULL;
	
	if ( $idNivel <= 0 ) {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar un Nivel" ) );
	}
	
	if ( !isset($familias) ) {
		echo json_encode( array( "codigo" => 2,
		"mensaje" => "No es posible guardar los datos porque falta proporcionar Familias" ) );
	}
	
	if ( $idNivel > 0 && isset($familias) ) {
		/*$afiliacion = new AfiliacionCliente($RBD, $WBD, $LOG);
		if ( !isset($idAfiliacion) ) {
			$afiliacion->setNivel($idNivel);
			foreach( $familias as $familia ) {
				$afiliacion->agregarFamilia($familia["id"]);
			}
			$resultado = $afiliacion->crearAfiliacion();
			if ( $resultado["success"] ) {
				echo json_encode( array( "codigo" => 0, "idAfiliacion" => $resultado["data"]["idAfiliacion"], "mensaje" => "Afiliacion creada exitosamente." ) );
			} else {
				echo json_encode( array( "codigo" => 1, "mensaje" => "Error al crear la Afiliacion: {$resultado['errmsg']}" ) );
			}
		} else {
			$afiliacion->load($idAfiliacion);
			if ( $afiliacion->ERROR_CODE == 0 ) {
				$afiliacion->setNivel($idNivel);
				$afiliacion->resetFamilias();
				foreach( $familias as $familia ) {
					$afiliacion->agregarFamilia($familia["id"]);
				}
				$resultado = $afiliacion->actualizarAfiliacion();
				if ( $resultado["success"] ) {
					echo json_encode( array( "codigo" => 0, "idAfiliacion" => $resultado["data"]["idAfiliacion"], "mensaje" => "Afiliacion creada exitosamente." ) );
				} else {
					echo json_encode( array( "codigo" => 1, "mensaje" => "Error al crear la Afiliacion: {$resultado['errmsg']}" ) );
				}
			} else {
				echo json_encode( array( "codigo" => 2, "mensaje" => "Error al crear la Afiliacion: $afiliacion->ERROR_MSG" ) );
			}
		}*/
	}
?>