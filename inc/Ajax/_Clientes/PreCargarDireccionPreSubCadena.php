<?php
	include("../../config.inc.php");
	include("../../session.inc.php");
	include("../../session.ajax.inc.php");
	include("../../obj/XMLPreSubCadena.php");

	$idSubCadena = isset($_SESSION['idPreSubCadena'])? $_SESSION['idPreSubCadena'] : NULL;
	
	if ( isset($idSubCadena) ) {
		
		$oSubcadena 	= new XMLPreSubCad($RBD,$WBD);
		$oSubcadena->load($idSubCadena);
		
		$calle 			= (!preg_match('!!u', $oSubcadena->getCalle()))? utf8_encode($oSubcadena->getCalle()) : $oSubcadena->getCalle();
		$numeroExterior = $oSubcadena->getNext();
		$numeroInterior = $oSubcadena->getNint();
		$pais 			= $oSubcadena->getPais();
		$nombrePais		= $oSubcadena->getNombrePais();
		$estado 		= $oSubcadena->getEstado();
		$ciudad 		= $oSubcadena->getCiudad();
		$colonia 		= $oSubcadena->getColonia();
		$codigoPostal 	= $oSubcadena->getCP();
		
		if ( !preg_match('!!u', $nombrePais) ) {
			//no es utf-8
			$nombrePais = utf8_encode($nombrePais);
		}
		
		if ( isset($calle, $numeroExterior, $numeroInterior, $pais, $estado, $ciudad, $colonia, $codigoPostal)
			&& !empty($calle) && !empty($numeroExterior) && !empty($pais) && !empty($estado)
			&& !empty($ciudad) && !empty($colonia) && !empty($codigoPostal) ) {
			echo json_encode(array( "codigoDeRespuesta" => 0, "calle" => $calle,
				"numeroExterior" => $numeroExterior, "numeroInterior" => $numeroInterior,
				"pais" => $pais, "nombrePais" => $nombrePais, "estado" => $estado,
				"ciudad" => $ciudad, "colonia" => $colonia,
				"codigoPostal" => $codigoPostal ));
		} else {
			echo json_encode(array( "codigoDeRespuesta" => 500, "mensajeDeRespuesta" => utf8_encode("No hay dirección dada de alta en el Paso 2 o esta se encuentra incompleta") ));
		}
		
	}
?>
