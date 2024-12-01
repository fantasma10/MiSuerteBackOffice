<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	
	$destino = (isset($_POST['destino']))? $_POST['destino'] : -1;
	$IVA = (isset($_POST['IVA']))? $_POST['IVA'] : -1;
	$numeroCuenta = (isset($_POST['numeroCuenta']))? $_POST['numeroCuenta'] : -1;
	$tipoActualizacion = (isset($_POST['tipoActualizacion']))? $_POST['tipoActualizacion'] : -1;
	$idPropietario = (isset($_POST['idPropietario']))? $_POST['idPropietario'] : -1;
	$tipoCuenta = (isset($_POST['tipoCuenta']))? $_POST['tipoCuenta'] : -1;
	$idEmpleado = $_SESSION['idU'];
	
	if ( $tipoActualizacion == 1 ) { //Actualizar Comision
		if ( $IVA != -1 ) {
			if ( $tipoCuenta == "Compartida" ) {
				$tipoFORELO = 1;
				$sqlEditarIva = "CALL `redefectiva`.`SP_EDITAR_IVA`($idPropietario, -1, -1, -1, $IVA, $tipoFORELO, $idEmpleado);";
				$resultEditarIva = $WBD->query($sqlEditarIva);
				if ( $WBD->error() == "" ) {
					$row = mysqli_fetch_assoc($resultEditarIva);
					$codigoEditarIva = $row["codigo"];
					if ( $codigoEditarIva != 0 ) {
						echo json_encode(array( "codigo" => 509, "mensaje" => "No es posible guardar configuracion de IVA. Por favor contacte a Soporte." ));
						exit();							
					}
				}				
			} else if ( $tipoCuenta == "Individual" ) {
				$tipoFORELO = 2;
				$sqlEditarIva = "CALL `redefectiva`.`SP_EDITAR_IVA`(-1, -1, -1, $idPropietario, $IVA, $tipoFORELO, $idEmpleado);";
				$resultEditarIva = $WBD->query($sqlEditarIva);
				if ( $WBD->error() == "" ) {
					$row = mysqli_fetch_assoc($resultEditarIva);
					$codigoEditarIva = $row["codigo"];
					if ( $codigoEditarIva != 0 ) {
						echo json_encode(array( "codigo" => 509, "mensaje" => "No es posible guardar configuracion de IVA. Por favor contacte a Soporte." ));
						exit();							
					}
				}				
			}
		}	
		$sql = "CALL `redefectiva`.`SP_EDITAR_LIQUIDACION`($numeroCuenta, NULL, $destino, $tipoActualizacion, $idEmpleado);";
		$result = $WBD->query($sql);
		if( $WBD->error() == "" ) {
			echo json_encode(array( "codigo" => 0, "mensaje" => "Configuración guardada exitosamente." ));
			exit();			
		} else {
			echo json_encode(array( "codigo" => 501, "mensaje" => "No es posible guardar configuración. Por favor contacte a Soporte. Error: ".$WBD->error() ));
			exit();		
		}		
	} else if ( $tipoActualizacion == 2 ) { //Actualizar Reembolso
		$sql = "CALL `redefectiva`.`SP_EDITAR_LIQUIDACION`($numeroCuenta, $destino, NULL, $tipoActualizacion, $idEmpleado);";
		$result = $WBD->query($sql);
		if( $WBD->error() == "" ) {
			echo json_encode(array( "codigo" => 0, "mensaje" => "Configuración guardada exitosamente." ));
			exit();			
		} else {
			echo json_encode(array( "codigo" => 502, "mensaje" => "No es posible guardar configuración. Por favor contacte a Soporte. Error: ".$WBD->error() ));
			exit();		
		}
	}
?>
