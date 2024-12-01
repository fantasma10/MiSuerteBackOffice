<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$calle = (isset($_POST['calle'])) ? trim($_POST['calle']) : '';
$nint = (isset($_POST['nint'])) ? trim($_POST['nint']) : '';
$next = (isset($_POST['next'])) ? trim($_POST['next']) : '';
$idpais = (isset($_POST['idpais'])) ? trim($_POST['idpais']) : -1;
$idestado = (isset($_POST['idestado'])) ? trim($_POST['idestado']) : -1;
$idciudad = (isset($_POST['idciudad'])) ? trim($_POST['idciudad']) : -1;
$idcolonia = (isset($_POST['idcolonia'])) ? trim($_POST['idcolonia']) : -1;
$cp = (isset($_POST['cp'])) ? trim($_POST['cp']) : -1;
$tipoDireccion = (isset($_POST['tipodireccion']))? trim($_POST['tipodireccion']) : '';
$id = (isset($_POST['id']))? trim($_POST['id']) : -1;
$idUsuario = $_SESSION["idU"];

if($calle != '' && $next != '' && $idpais > -1 && $idestado > -1 && $idciudad > -1 && $id > -1 ){
    
    $oCadena = new Cadena($RBD,$WBD);
    $oCadena->load($id);
    $calle = utf8_decode($calle);
    $oCadena->setCalle($calle);
    $oCadena->setNext($next);
    $oCadena->setNint($nint);
	if ( $tipoDireccion == "nacional" ) {
    	$oCadena->setColonia($idcolonia);
    	$oCadena->setCiudad($idciudad);
    	$oCadena->setEstado($idestado);
	} else if ( $tipoDireccion == "extranjera" ) {
		$idestado = utf8_decode($idestado);
		$idciudad = utf8_decode($idciudad);
		$idcolonia = utf8_decode($idcolonia);
		$sql = "CALL `redefectiva`.`SP_FIND_ESTADOEXTRANJERO`($idpais, '$idestado');";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				list( $idEstadoExtranjero ) = $result->fetch_array();
				$oCadena->setEstado($idEstadoExtranjero);
			} else {
				$sql = "CALL `redefectiva`.`SP_INSERT_ESTADOEXTRANJERO`($idpais, '$idestado', {$_SESSION['idU']});";
				$result = $RBD->SP($sql);
				if ( $RBD->error() == '' ) {
					$sql = "CALL `redefectiva`.`SP_FIND_ESTADOEXTRANJERO`($idpais, '$idestado');";
					$result = $RBD->SP($sql);
					if ( $RBD->error() == '' ) {
						list( $idEstadoExtranjero ) = $result->fetch_array();
						$oCadena->setEstado($idEstadoExtranjero);
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
		$sql = "CALL `redefectiva`.`SP_FIND_CIUDADEXTRANJERA`($idEstadoExtranjero, '$idciudad');";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				list( $idCiudadExtranjera ) = $result->fetch_array();
				$oCadena->setCiudad($idCiudadExtranjera);
			} else {
				$sql = "CALL `redefectiva`.`SP_INSERT_CIUDADEXTRANJERA`($idEstadoExtranjero, $idpais, '$idciudad', {$_SESSION['idU']});";
				$result = $RBD->SP($sql);
				if ( $RBD->error() == '' ) {
					$sql = "CALL `redefectiva`.`SP_FIND_CIUDADEXTRANJERA`($idEstadoExtranjero, '$idciudad')";
					$result = $RBD->SP($sql);
					if ( $RBD->error == '' ) {
						if ( $result->num_rows > 0 ) {
							list( $idCiudadExtranjera ) = $result->fetch_array();
							$oCadena->setCiudad($idCiudadExtranjera);
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
		$sql = "CALL `redefectiva`.`SP_FIND_COLONIAEXTRANJERA`($idpais, $idEstadoExtranjero, $idCiudadExtranjera, '$idcolonia');";
		$result = $RBD->SP($sql);
		if ( $RBD->error() == '' ) {
			if ( $result->num_rows > 0 ) {
				list( $idColoniaExtranjera ) = $result->fetch_array();
				$oCadena->setColonia($idColoniaExtranjera);	
			} else {
				$sql = "CALL `redefectiva`.`SP_INSERT_COLONIAEXTRANJERA`($idpais, $idEstadoExtranjero, $idCiudadExtranjera, '$idcolonia', {$_SESSION['idU']});";
				$result = $RBD->SP($sql);
				if ( $RBD->error() == '' ) {
					$sql = "CALL `redefectiva`.`SP_FIND_COLONIAEXTRANJERA`($idpais, $idEstadoExtranjero, $idCiudadExtranjera, '$idcolonia');";
					$result = $RBD->SP($sql);
					if ( $RBD->error() == '' ) {
						list( $idColoniaExtranjera ) = $result->fetch_array();
						$oCadena->setColonia($idColoniaExtranjera);	
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
    $oCadena->setCP($cp);
    $oCadena->setPais($idpais);
    $oCadena->setTipoDireccion(2);

    if($oCadena->GuardarDireccion($idUsuario)){
        echo utf8_encode("0|Se guardó la dirección");
    }else{
        echo utf8_encode("1|No se guardó la dirección");
    }
	
}
?>