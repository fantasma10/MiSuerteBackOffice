<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");


$rfc 			= (isset($_POST['rfc'])) ? trim($_POST['rfc']) : '';
$rsocial 		= (isset($_POST['rsocial'])) ? trim($_POST['rsocial']) : '';
$fconstitucion 	= (isset($_POST['fconstitucion'])) ? trim($_POST['fconstitucion']) : '';
$regimen 		= (isset($_POST['regimen'])) ? trim($_POST['regimen']) : '';

$calle 			= (isset($_POST['calle'])) ? trim($_POST['calle']) : '';
$nint 			= (isset($_POST['nint'])) ? trim($_POST['nint']) : '';
$next 			= (isset($_POST['next'])) ? trim($_POST['next']) : '';
$idpais 		= (isset($_POST['idpais'])) ? trim($_POST['idpais']) : -1;
$idestado 		= (isset($_POST['idestado'])) ? trim($_POST['idestado']) : -1;
$idciudad 		= (isset($_POST['idciudad'])) ? trim($_POST['idciudad']) : -1;
$idcolonia 		= (isset($_POST['idcolonia'])) ? trim($_POST['idcolonia']) : -1;
$cp 			= (isset($_POST['cp'])) ? trim($_POST['cp']) : 0;
$tipoDireccion	= (isset($_POST['tipodireccion'])) ? trim($_POST['tipodireccion']) : NULL;

$nombre 		= (isset($_POST['nombre'])) ? trim($_POST['nombre']) : '';
$paterno		= (isset($_POST['paterno'])) ? trim($_POST['paterno']) : '';
$materno 		= (isset($_POST['materno'])) ? trim($_POST['materno']) : '';
$numiden 		= (isset($_POST['numiden'])) ? trim($_POST['numiden']) : '';
$tipoiden 		= (isset($_POST['tipoiden'])) ? trim($_POST['tipoiden']) : '';
$rrfc 			= (isset($_POST['rrfc'])) ? trim($_POST['rrfc']) : '';
$curp 			= (isset($_POST['curp'])) ? trim($_POST['curp']) : '';
$figura 		= (isset($_POST['figura'])) ? trim($_POST['figura']) : '';
$familia 		= (isset($_POST['familia'])) ? trim($_POST['familia']) : '';

$DirGral 		= (isset($_POST['dirGral'])) ? trim($_POST['dirGral']) : true;

if($rfc != '' && $rsocial != '' && $fconstitucion != '' && $regimen != ''){
    $oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
    $oCorresponsal->load($_SESSION['idPreCorresponsal']);
    $oCorresponsal->setID($_SESSION['idPreCorresponsal']);
	
    $oCorresponsal->setCRRfc($rfc);
    $oCorresponsal->setCRSocial($rsocial);
    $oCorresponsal->setCFConstitucion($fconstitucion);
    $oCorresponsal->setCRegimen($regimen);
   
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
    $oCorresponsal->setTipoDireccion(1);// 1 es direccion de corresponsal
    
    $oCorresponsal->setCNombre($nombre);
    $oCorresponsal->setCPaterno($paterno);
    $oCorresponsal->setCMaterno($materno);
    $oCorresponsal->setCNumIden($numiden);
    $oCorresponsal->setCRTipoIden($tipoiden);
    $oCorresponsal->setCRfc($rrfc);
    $oCorresponsal->setCCurp($curp);
    $oCorresponsal->setCFigura($figura);
    $oCorresponsal->setCFamilia($familia);
    $oCorresponsal->setCTipoDireccion(8);// 8 direccion fiscal
	
   	if($DirGral == "false")
	    $oCorresponsal->setCDireccion($oCorresponsal->getDireccion());
	else
	    $oCorresponsal->GuardarDireccionContrato();
	
    if ( $oCorresponsal->GuardarContrato() ) {
		if ( $oCorresponsal->GuardarRepLegal() ) {
	    	if ( $oCorresponsal->GuardarXML() ) {
				echo "0|Se guardo el contrato";			
	    	} else {
				echo "1|error al guardar el XML";
			}
		}else{
			echo "2|Error al guardar el representante legal. ".$oCorresponsal->getError();
		}
    }else{
        echo "4|No se pudo guardar el contrato";
    }
}

?>