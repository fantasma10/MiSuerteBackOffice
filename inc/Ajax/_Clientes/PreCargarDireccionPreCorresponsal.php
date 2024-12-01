<?php
	include("../../config.inc.php");
	include("../../session.inc.php");
	include("../../session.ajax.inc.php");
	include("../../obj/XMLPreCorresponsal.php");

	$idCorresponsal = isset($_SESSION['idPreCorresponsal'])? $_SESSION['idPreCorresponsal'] : NULL;
	
	if ( isset($idCorresponsal) ) {
		
		$oCorresponsal 	= new XMLPreCorresponsal($RBD,$WBD);
		$oCorresponsal->load($idCorresponsal);
		
		$calle 			= $oCorresponsal->getCalle();
		$numeroExterior = $oCorresponsal->getNext();
		$numeroInterior = $oCorresponsal->getNint();
		$pais 			= $oCorresponsal->getPais();
		$estado 		= $oCorresponsal->getEstado();
		$ciudad 		= $oCorresponsal->getCiudad();
		$colonia 		= $oCorresponsal->getColonia();
		$codigoPostal 	= $oCorresponsal->getCP();
		
		if ( isset($calle, $numeroExterior, $numeroInterior, $pais, $estado, $ciudad, $colonia, $codigoPostal)
			&& !empty($calle) && !empty($numeroExterior) && !empty($pais) && !empty($estado)
			&& !empty($ciudad) && !empty($colonia) && !empty($codigoPostal) ) {
			echo json_encode(array( "codigoDeRespuesta" => 0, "calle" => $calle,
				"numeroExterior" => $numeroExterior, "numeroInterior" => $numeroInterior,
				"pais" => $pais, "estado" => $estado,
				"ciudad" => $ciudad, "colonia" => $colonia,
				"codigoPostal" => $codigoPostal ));
		} else {
			echo json_encode(array( "codigoDeRespuesta" => 500, "mensajeDeRespuesta" => "No hay direccion dada de alta en el Paso2 o esta se encuentra incompleta" ));
		}
		
	}
?>