<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$calle = (isset($_POST['calle'])) ? trim($_POST['calle']) : '';
$nint = (isset($_POST['nint'])) ? trim($_POST['nint']) : '';
$next = (isset($_POST['next'])) ? trim($_POST['next']) : '';
$idpais = (isset($_POST['idpais'])) ? trim($_POST['idpais']) : -1;
$idestado = (isset($_POST['idestado'])) ? trim($_POST['idestado']) : -1;
$idciudad = (isset($_POST['idciudad'])) ? trim($_POST['idciudad']) : -1;
$idcolonia = (isset($_POST['idcolonia'])) ? trim($_POST['idcolonia']) : -1;
$cp = (isset($_POST['cp'])) ? trim($_POST['cp']) : 0;
$tipoDireccion = (isset($_POST['tipodireccion']))? trim($_POST['tipodireccion']) : -1;

$DE1 = (isset($_POST['DE1'])) ? trim($_POST['DE1']) : '';
$A1 = (isset($_POST['A1'])) ? trim($_POST['A1']) : '';
$DE2 = (isset($_POST['DE2'])) ? trim($_POST['DE2']) : '';
$A2 = (isset($_POST['A2'])) ? trim($_POST['A2']) : '';
$DE3 = (isset($_POST['DE3'])) ? trim($_POST['DE3']) : '';
$A3 = (isset($_POST['A3'])) ? trim($_POST['A3']) : '';
$DE4 = (isset($_POST['DE4'])) ? trim($_POST['DE4']) : '';
$A4 = (isset($_POST['A4'])) ? trim($_POST['A4']) : '';
$DE5 = (isset($_POST['DE5'])) ? trim($_POST['DE5']) : '';
$A5 = (isset($_POST['A5'])) ? trim($_POST['A5']) : '';
$DE6 = (isset($_POST['DE6'])) ? trim($_POST['DE6']) : '';
$A6 = (isset($_POST['A6'])) ? trim($_POST['A6']) : '';
$DE7 = (isset($_POST['DE7'])) ? trim($_POST['DE7']) : '';
$A7 = (isset($_POST['A7'])) ? trim($_POST['A7']) : '';


//if($idcadena > -1){
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($_SESSION['idPreCorresponsal']);
    $oCorresponsal->setID($_SESSION['idPreCorresponsal']);
    //$oCorresponsal->setNombre($_SESSION['nombrePreCorresponsal']);
    $calle = utf8_decode($calle);
	$oCorresponsal->setCalle($calle);
    $oCorresponsal->setNint($nint);
    $oCorresponsal->setNext($next);
    $oCorresponsal->setPais($idpais);
	if ( $tipoDireccion == "nacional" ) {
    	$oCorresponsal->setColonia($idcolonia);
    	$oCorresponsal->setCiudad($idciudad);
    	$oCorresponsal->setEstado($idestado);
	} else if ( $tipoDireccion == "extranjera" ) {
		$idestado = utf8_decode($idestado);
		$idciudad = utf8_decode($idciudad);
		$idcolonia = utf8_decode($idcolonia);
		$sql = "CALL `prealta`.`SP_FIND_ESTADOEXTRANJERO`($idpais, '$idestado');";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				list( $idEstadoExtranjero ) = $result->fetch_array();
				$oCorresponsal->setEstado($idEstadoExtranjero);
			} else {
				$sql = "CALL `prealta`.`SP_INSERT_ESTADOEXTRANJERO`($idpais, '$idestado', {$_SESSION['idU']});";
				$result = $RBD->SP($sql);
				if ( $RBD->error() == '' ) {
					$sql = "CALL `prealta`.`SP_FIND_ESTADOEXTRANJERO`($idpais, '$idestado');";
					$result = $RBD->SP($sql);
					if ( $RBD->error() == '' ) {
						list( $idEstadoExtranjero ) = $result->fetch_array();
						$oCorresponsal->setEstado($idEstadoExtranjero);
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
				$oCorresponsal->setCiudad($idCiudadExtranjera);
			} else {
				$sql = "CALL `prealta`.`SP_INSERT_CIUDADEXTRANJERA`($idEstadoExtranjero, $idpais, '$idciudad', {$_SESSION['idU']});";
				$result = $RBD->SP($sql);
				if ( $RBD->error() == '' ) {
					$sql = "CALL `prealta`.`SP_FIND_CIUDADEXTRANJERA`($idEstadoExtranjero, '$idciudad')";
					$result = $RBD->SP($sql);
					if ( $RBD->error == '' ) {
						if ( $result->num_rows > 0 ) {
							list( $idCiudadExtranjera ) = $result->fetch_array();
							$oCorresponsal->setCiudad($idCiudadExtranjera);
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
				$oCorresponsal->setColonia($idColoniaExtranjera);
			} else {
				$sql = "CALL `prealta`.`SP_INSERT_COLONIAEXTRANJERA`($idpais, $idEstadoExtranjero, $idCiudadExtranjera, '$idcolonia', {$_SESSION['idU']});";
				$result = $RBD->SP($sql);
				if ( $RBD->error() == '' ) {
					$sql = "CALL `prealta`.`SP_FIND_COLONIAEXTRANJERA`($idpais, $idEstadoExtranjero, $idCiudadExtranjera, '$idcolonia');";
					$result = $RBD->SP($sql);
					if ( $RBD->error() == '' ) {
						list( $idColoniaExtranjera ) = $result->fetch_array();
						$oCorresponsal->setColonia($idColoniaExtranjera);	
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
    $oCorresponsal->setCP($cp);
    $oCorresponsal->setTipoDireccion(2);// 2 es direccion de subcadena
    	
    $oCorresponsal->setHDe1($DE1);
    $oCorresponsal->setHA1($A1);
    $oCorresponsal->setHDe2($DE2);
    $oCorresponsal->setHA2($A2);
    $oCorresponsal->setHDe3($DE3);
    $oCorresponsal->setHA3($A3);
    $oCorresponsal->setHDe4($DE4);
    $oCorresponsal->setHA4($A4);
    $oCorresponsal->setHDe5($DE5);
    $oCorresponsal->setHA5($A5);
    $oCorresponsal->setHDe6($DE6);
    $oCorresponsal->setHA6($A6);
    $oCorresponsal->setHDe7($DE7);
    $oCorresponsal->setHA7($A7);
    
	if ( $DE1 != '' && $A1 != '' && $DE2 != '' && $A2 != ''
	&& $DE3 != '' && $A3 != '' && $DE4 != '' && $A4 != ''
	&& $DE5 != '' && $A5 != '' && $DE6 != '' && $A6 != ''
	&& $DE7 != '' && $A7 != '' ) {
		$seActualizoHorario = true;
	} else {
		$seActualizoHorario = false;
	}

	$oCorresponsal->setSeActualizoHorario($seActualizoHorario);

	$oCorresponsal->setPreRevisadoCargos(false);
    $oCorresponsal->setPreRevisadoBancos(false);
    $oCorresponsal->setPreRevisadoVersion(false);
    $oCorresponsal->setPreRevisadoDocumentacion(false);
    $oCorresponsal->setPreRevisadoGenerales(false);
    $oCorresponsal->setPreRevisadoDireccion(false);
    $oCorresponsal->setPreRevisadoContactos(false);
    $oCorresponsal->setPreRevisadoCuenta(false);
    $oCorresponsal->setRevisadoCargos(false);
    $oCorresponsal->setRevisadoBancos(false);
    $oCorresponsal->setRevisadoVersion(false);
    $oCorresponsal->setRevisadoDocumentacion(false);
    $oCorresponsal->setRevisadoGenerales(false);
    $oCorresponsal->setRevisadoDireccion(false);
    $oCorresponsal->setRevisadoContactos(false);
    $oCorresponsal->setRevisadoEjecutivos(false);
    $oCorresponsal->setRevisadoCuenta(false);
    $oCorresponsal->setRevisadoContrato(false);
    $oCorresponsal->setRevisadoForelo(false);

    if ( $oCorresponsal->GuardarDireccion() ) {
        if ( $seActualizoHorario ) {
			echo "0|Se guardaron la direccion y el horario";
		} else {
			echo "0|Se guardo la direccion ";
		}
    } else {
        echo "1|No se pudo guardar la direccion ni el horario";
	}
    
//}

?>