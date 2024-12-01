<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$calle = (isset($_POST['calle'])) ? trim($_POST['calle']) : '';
$nint = (isset($_POST['nint'])) ? trim($_POST['nint']) : '';
$next = (isset($_POST['next'])) ? trim($_POST['next']) : '';
$idpais = (isset($_POST['idpais'])) ? trim($_POST['idpais']) : -1;
$idestado = (isset($_POST['idestado'])) ? trim($_POST['idestado']) : -1;
$idciudad = (isset($_POST['idciudad'])) ? trim($_POST['idciudad']) : -1;
$idcolonia = (isset($_POST['idcolonia'])) ? trim($_POST['idcolonia']) : -1;
$cp = (isset($_POST['cp'])) ? trim($_POST['cp']) : 0;
$tipoDireccion = (isset($_POST['tipodireccion']))? trim($_POST['tipodireccion']) : -1;

//if($idcadena > -1){
    $oSubcadena = new XMLPreSubCad($RBD,$WBD);
    $oSubcadena->load($_SESSION['idPreSubCadena']);
    $oSubcadena->setID($_SESSION['idPreSubCadena']);
    //$_SESSION['nombrePreSubCadena'] = $nombre;
	$calle = utf8_decode($calle);
	$oSubcadena->setCalle($calle);
    $oSubcadena->setNint($nint);
    $oSubcadena->setNext($next);
    $oSubcadena->setPais($idpais);
	if ( $tipoDireccion == "nacional" ) {
    	$oSubcadena->setColonia($idcolonia);
    	$oSubcadena->setCiudad($idciudad);
    	$oSubcadena->setEstado($idestado);
	} else if ( $tipoDireccion == "extranjera" ) {
		$idestado = utf8_decode($idestado);
		$idciudad = utf8_decode($idciudad);
		$idcolonia = utf8_decode($idcolonia);
		$sql = "CALL `prealta`.`SP_FIND_ESTADOEXTRANJERO`($idpais, '$idestado');";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				list( $idEstadoExtranjero ) = $result->fetch_array();
				$oSubcadena->setEstado($idEstadoExtranjero);
			} else {
				$sql = "CALL `prealta`.`SP_INSERT_ESTADOEXTRANJERO`($idpais, '$idestado', {$_SESSION['idU']});";
				$result = $RBD->SP($sql);
				if ( $RBD->error() == '' ) {
					$sql = "CALL `prealta`.`SP_FIND_ESTADOEXTRANJERO`($idpais, '$idestado');";
					$result = $RBD->SP($sql);
					if ( $RBD->error() == '' ) {
						list( $idEstadoExtranjero ) = $result->fetch_array();
						$oSubcadena->setEstado($idEstadoExtranjero);
					} else {
						echo "5|Error al buscar estado extranjero";
						break;
					}	
				} else {
					echo "4|Error al insertar estado extranjero";
					break;
				}
			}	
		} else {
			echo "2|Error al guardar la direccion";
			break;
		}
		$sql = "CALL `prealta`.`SP_FIND_CIUDADEXTRANJERA`($idEstadoExtranjero, '$idciudad');";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				list( $idCiudadExtranjera ) = $result->fetch_array();
				$oSubcadena->setCiudad($idCiudadExtranjera);
			} else {
				$sql = "CALL `prealta`.`SP_INSERT_CIUDADEXTRANJERA`($idEstadoExtranjero, $idpais, '$idciudad', {$_SESSION['idU']});";
				$result = $RBD->SP($sql);
				if ( $RBD->error() == '' ) {
					$sql = "CALL `prealta`.`SP_FIND_CIUDADEXTRANJERA`($idEstadoExtranjero, '$idciudad')";
					$result = $RBD->SP($sql);
					if ( $RBD->error == '' ) {
						if ( $result->num_rows > 0 ) {
							list( $idCiudadExtranjera ) = $result->fetch_array();
							$oSubcadena->setCiudad($idCiudadExtranjera);
						} else {
							echo "8|Error al buscar ciudad extranjera";
							break;
						}
					} else {
						echo "7|Error al buscar ciudad extranjera";
						break;
					}
				} else {
					echo "6|Error al insertar ciudad extranjera";
					break;
				}
			}
		} else {
			echo "3|Error al guardar la direccion";
			break;
		}
		$sql = "CALL `prealta`.`SP_FIND_COLONIAEXTRANJERA`($idpais, $idEstadoExtranjero, $idCiudadExtranjera, '$idcolonia');";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				list( $idColoniaExtranjera ) = $result->fetch_array();
				$oSubcadena->setColonia($idColoniaExtranjera);
			} else {
				$sql = "CALL `prealta`.`SP_INSERT_COLONIAEXTRANJERA`($idpais, $idEstadoExtranjero, $idCiudadExtranjera, '$idcolonia', {$_SESSION['idU']});";
				$result = $RBD->SP($sql);
				if ( $RBD->error() == '' ) {
					$sql = "CALL `prealta`.`SP_FIND_COLONIAEXTRANJERA`($idpais, $idEstadoExtranjero, $idCiudadExtranjera, '$idcolonia');";
					$result = $RBD->SP($sql);
					if ( $RBD->error() == '' ) {
						list( $idColoniaExtranjera ) = $result->fetch_array();
						$oSubcadena->setColonia($idColoniaExtranjera);	
					} else {
						echo "11|Error al buscar ciudad extranjera";
						break;
					}
				} else {
					echo "10|Error al insertar colonia extranjera";
					break;
				}
			}
		} else {
			echo "9|Error al buscar colonia extranjera";
			break;
		}
	}
    $oSubcadena->setCP($cp);
    $oSubcadena->setTipoDireccion(2);// 2 es direccion de subcadena

    $oSubcadena->setPreRevisadoVersion(false);
    $oSubcadena->setPreRevisadoCargos(false);
    $oSubcadena->setPreRevisadoGenerales(false);
    $oSubcadena->setPreRevisadoDireccion(false);
    $oSubcadena->setPreRevisadoContactos(false);
    $oSubcadena->setPreRevisadoEjecutivos(false);
    $oSubcadena->setPreRevisadoDocumentacion(false);
    $oSubcadena->setPreRevisadoCuenta(false);
    $oSubcadena->setPreRevisadoContrato(false);
    $oSubcadena->setRevisadoCargos(false);
    $oSubcadena->setRevisadoDocumentacion(false);
    $oSubcadena->setRevisadoGenerales(false);
    $oSubcadena->setRevisadoDireccion(false);
    $oSubcadena->setRevisadoContactos(false);
    $oSubcadena->setRevisadoEjecutivos(false);
    $oSubcadena->setRevisadoCuenta(false);
    $oSubcadena->setRevisadoVersion(false);
    $oSubcadena->setRevisadoContrato(false);
    $oSubcadena->setRevisadoForelo(false);

    if($oSubcadena->GuardarDireccion()){
        echo utf8_encode("0|Se guardó la dirección");
    } else {
        echo utf8_encode("1|No se pudo guardar la dirección");
    }
	//echo $oSubcadena->GuardarXML();
    
//}

?>