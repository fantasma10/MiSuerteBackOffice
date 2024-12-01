<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$rfc = (isset($_POST['rfc'])) ? strtoupper(trim($_POST['rfc'])) : '';
$rsocial = (isset($_POST['rsocial'])) ? trim($_POST['rsocial']) : '';
$fconstitucion = (isset($_POST['fconstitucion'])) ? trim($_POST['fconstitucion']) : '';
$regimen = (isset($_POST['regimen'])) ? trim($_POST['regimen']) : '';

$calle = (isset($_POST['calle'])) ? trim($_POST['calle']) : '';
$nint = (isset($_POST['nint'])) ? trim($_POST['nint']) : '';
$next = (isset($_POST['next'])) ? trim($_POST['next']) : '';
$idpais = (isset($_POST['idpais'])) ? trim($_POST['idpais']) : -1;
$idestado = (isset($_POST['idestado'])) ? trim($_POST['idestado']) : -1;
$idciudad = (isset($_POST['idciudad'])) ? trim($_POST['idciudad']) : -1;
$idcolonia = (isset($_POST['idcolonia'])) ? trim($_POST['idcolonia']) : -1;
$cp = (isset($_POST['cp'])) ? trim($_POST['cp']) : 0;
$tipoDireccion = (isset($_POST['tipodireccion']))? trim($_POST['tipodireccion']) : -1;

$nombre = (isset($_POST['nombre'])) ? trim($_POST['nombre']) : '';
$paterno = (isset($_POST['paterno'])) ? trim($_POST['paterno']) : '';
$materno = (isset($_POST['materno'])) ? trim($_POST['materno']) : '';
$numiden = (isset($_POST['numiden'])) ? trim($_POST['numiden']) : '';
$tipoiden = (isset($_POST['tipoiden'])) ? trim($_POST['tipoiden']) : '';
$rrfc = (isset($_POST['rrfc'])) ? strtoupper(trim($_POST['rrfc'])) : '';
$curp = (isset($_POST['curp'])) ? strtoupper(trim($_POST['curp'])) : '';
$figura = (isset($_POST['figura'])) ? trim($_POST['figura']) : '';
$familia = (isset($_POST['familia'])) ? trim($_POST['familia']) : '';

$DirGral 		= (isset($_POST['dirGral'])) ? trim($_POST['dirGral']) : true;

if ( isset($fconstitucion) && $fconstitucion != '' ) {
	$fconstitucion = date("Y-m-d", strtotime($fconstitucion));
}

if ( !isset($fconstitucion) || $fconstitucion == '' ) {
	$fconstitucion = "NULL";
}

if($rfc != '' && $rsocial != '' && $regimen != ''){
	$rsocial = utf8_decode($rsocial);
	$nombre = utf8_decode($nombre);
	$paterno = utf8_decode($paterno);
	$materno = utf8_decode($materno);
	$oSubcadena = new XMLPreSubCad($RBD,$WBD);
    $oSubcadena->load($_SESSION['idPreSubCadena']);
    $oSubcadena->setID($_SESSION['idPreSubCadena']);
	$oSubcadena->setCRfc($rfc);
    $oSubcadena->setCRRfc($rrfc);
    $oSubcadena->setCRSocial($rsocial);
    $oSubcadena->setCFConstitucion($fconstitucion);
    $oSubcadena->setCRegimen($regimen);
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
			echo utf8_encode("2|Error al guardar la dirección");
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
			echo utf8_encode("3|Error al guardar la dirección");
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
    $oSubcadena->setCNombre($nombre);
    $oSubcadena->setCPaterno($paterno);
    $oSubcadena->setCMaterno($materno);
    $oSubcadena->setCNumIden($numiden);
    $oSubcadena->setCRTipoIden($tipoiden);
    $oSubcadena->setCRRfc($rrfc);
	$oSubcadena->setCRfc($rfc);
    $oSubcadena->setCCurp($curp);
    $oSubcadena->setCFigura($figura);
    $oSubcadena->setCFamilia($familia);
    $oSubcadena->setCTipoDireccion(8);// 8 direccion fiscal

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

    if($DirGral == "false")
	    $oSubcadena->setCDireccion($oSubcadena->getDireccion());
	else
	    $oSubcadena->GuardarDireccionContrato();

    if ( $oSubcadena->GuardarContrato() ) {
		if( $oSubcadena->GuardarRepLegal() ) {
	    	if ( $oSubcadena->GuardarXML() ) {
				echo utf8_encode("0|Se guardó el contrato");
	    	} else {
				echo "1|Error al guardar el XML";
			}
		} else {
			echo utf8_encode("2|Error al guardar el Representante Legal. ".$oSubcadena->getError());
		}
    } else {
        echo "4|No se pudo guardar el contrato";
    }

}

?>