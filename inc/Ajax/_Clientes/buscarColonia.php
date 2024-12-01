<?php
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");
	
	$codigoPostal = isset( $_POST['codigoPostal'] ) ? $_POST['codigoPostal'] : -1;
	
	if ( $codigoPostal > 0 ) {
		
		$sql = "CALL `redefectiva`.`SP_BUSCARCOLONIA`('$codigoPostal');";
		$listaColonias = array();
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				$idColonia = array();
				$nombreColonia = array();
				$i = 0;
				while ( list( $id, $nom, $idEnt, $idCd, $nomCd, $nomEnt ) = $result->fetch_array() ) {
					$idColonia[$i] = $id;
					$nombreColonia[$i] = htmlentities($nom);
					$idEntidad = $idEnt;
					$idCiudad = $idCd;
					$entidad = utf8_encode($nomEnt);
					$ciudad = utf8_encode($nomCd);

					$listaColonias[] = array(
						"nombreColonia"	=> (!preg_match("!!u", $nom))? utf8_encode($nom) : $nom,
						"idColonia"		=> $id
					);
					$i++;
				}
				//echo "<pre>".var_dump($listaColonias)."</pre>";
				asort($listaColonias);
				//echo "<pre>".var_dump($listaColonias)."</pre>";
				echo json_encode( array( "codigoDeRespuesta" => 0, "mensajeDeRespuesta" => "Consulta exitosa",
				"idColonia" => $idColonia, "nombre" => $nombreColonia, "idEntidad" => $idEntidad, "idCiudad" => $idCiudad,
				"entidad" => $entidad, "ciudad" => $ciudad, "listaColonias" => $listaColonias ) );
			} else {
				echo json_encode( array( "codigoDeRespuesta" => 1, "mensajeDeRespuesta" => "No se encontraron colonias" ) );
			}
		} else {
			echo json_encode( array( "codigoDeRespuesta" => 2, "mensajeDeRespuesta" => "No se pudo consultar la base de datos: ".$RBD->error() ) );
		}
			
	}
?>
