<?php
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");
	
	$idNivel = !empty( $_POST['idNivel'] )? $_POST['idNivel'] : -500;
	
	$sql = "CALL `afiliacion`.`SP_GET_EXPEDIENTE`($idNivel);";
	$result = $RBD->SP($sql);
	
	if ( $RBD->error() == "" ) {
		if ( $result->num_rows > 0 ) {
			$paquetes = array( "idNivel" => array(), "nombreNivel" => array(),
			"idFamilia" => array(), "descripcionFamilia" => array() );
			while ( list( $idNivel, $nombreNivel, $idFamilia, $descripcionFamilia ) = $result->fetch_array() ) {
				$paquetes["idNivel"][] = $idNivel;
				$paquetes["nombreNivel"][] = utf8_encode($nombreNivel);
				$paquetes["idFamilia"][] = $idFamilia;
				$paquetes["descripcionFamilia"][] = utf8_encode($descripcionFamilia);
			}
			$sql = "CALL `afiliacion`.`SP_GET_TIPOEXPEDIENTE`(NULL);";
			$result = $RBD->SP($sql);
			$niveles = array( "idNivel" => array(), "nombreNivel" => array(),
			"descripcion" => array() );
			if ( $RBD->error() == "" ) {
				if ( $result->num_rows > 0 ) {
					while ( list( $idNivel, $nombreNivel, $descripcion ) = $result->fetch_array() ) {
						$niveles["idNivel"][] = $idNivel;
						$niveles["nombreNivel"][] = utf8_encode($nombreNivel);
						$niveles["descripcion"][] = utf8_encode($descripcion);
					}
				} else {
					echo json_encode( array( "codigo" => 4,
					"mensaje" => "No hay niveles dados de alta en la base de datos." ) );
				}
			} else {
				echo json_encode( array( "codigo" => 3,
				"mensaje" => "No se pudo consultar la base de datos para obtener niveles. Error: ".$RBD->error() ) );
			}
			$sql = "CALL `redefectiva`.`SP_LOAD_FAMILIAS`();";
			$result = $RBD->SP($sql);
			$familias = array( "idFamilia" => array(), "nombreFamilia" => array() );
			if ( $RBD->error() == "" ) {
				if ( $result->num_rows > 0 ) {
					while ( list( $idFamilia, $nombreFamilia ) = $result->fetch_array() ) {
						$familias["idFamilia"][] = $idFamilia;
						$familias["nombreFamilia"][] = utf8_encode($nombreFamilia);
					}
				} else {
					echo json_encode( array( "codigo" => 6,
					"mensaje" => "No hay familias dadas de alta en la base de datos." ) );				
				}
			} else {
				echo json_encode( array( "codigo" => 5,
				"mensaje" => "No se pudo consultar la base de datos para obtener niveles. Error: ".$RBD->error() ) );			
			}
		} else {
			echo json_encode( array( "codigo" => 2,
			"mensaje" => "No hay expedientes dados de alta en la base de datos." ) );
		}
		echo json_encode( array( "codigo" => 0, "paquetes" => $paquetes, "niveles" => $niveles,
		"familias" => $familias, "mensaje" => "Consulta exitosa" ) );
	} else {
		echo json_encode( array( "codigo" => 1,
		"mensaje" => "No se pudo consultar la base de datos para obtener paquete(s). Error: ".$RBD->error() ) );
	}
?>