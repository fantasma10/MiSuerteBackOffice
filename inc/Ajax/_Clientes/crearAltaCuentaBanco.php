<?php
session_start();
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	
	$numeroCuenta = (isset($_POST['numeroCuenta']))? $_POST['numeroCuenta'] : NULL;
	$tipoMovimiento = (isset($_POST['tipoMovimiento']))? $_POST['tipoMovimiento'] : NULL;
	$tipoInstruccion = (isset($_POST['tipoInstruccion']))? $_POST['tipoInstruccion'] : NULL;
	$referencia		= (isset($_POST["referencia"]))? $_POST["referencia"] : '';
	$CLABE = (isset($_POST['CLABE']))? $_POST['CLABE'] : -1;
	$beneficiario = (isset($_POST['beneficiario']))? $_POST['beneficiario'] : -1;
	$RFC = (isset($_POST['RFC']))? $_POST['RFC'] : -1;
	$correo = (isset($_POST['correo']))? $_POST['correo'] : -1;
	$idEmpleado = $_SESSION['idU'];
	
	$RFC = strtoupper($RFC);
	$beneficiario = utf8_decode($beneficiario);
	
	if ( isset($numeroCuenta) && isset($tipoMovimiento) && isset($tipoInstruccion) ) {
		$sqlValidacion = "SELECT COUNT(`idConfiguracion`) AS `total`
		FROM `data_contable`.`conf_cuenta`  
		WHERE `numCuenta` = $numeroCuenta
		AND `idEstatus` = 0
		AND `idTipoInstruccion` = $tipoInstruccion
		AND `idTipoOperacion` = $tipoMovimiento;";
		$resultValidacion = $RBD->query($sqlValidacion);
		if ( $RBD->error() == '' ) {
			$row = mysqli_fetch_assoc($resultValidacion);
			$total = $row["total"];
			if ( $total > 0 ) {
				echo json_encode(array( "codigo" => 503, "mensaje" => utf8_encode("Ya existe una cuenta con la configuracion seleccionada.") ));
				exit();			
			}
		} else {
			echo json_encode(array( "codigo" => 502, "mensaje" => utf8_encode("No es posible guardar cuenta. Por favor contacte a Soporte. Error: ".$RBD->error()) ));
			exit();		
		}
	}

	if ( $total == 0 ) {
		$sqlA = "CALL `data_contable`.`SP_ALTA_CUENTA_BANCO`(0, $tipoInstruccion, $tipoMovimiento,  '$numeroCuenta', '$CLABE', '$RFC', '$referencia', '$beneficiario', '$correo', @resultCode, @resultMsg, $idEmpleado);";
		$resultA = $WBD->SP($sqlA);
		if ( $WBD->error() == '' ) {
			$sqlB = "SELECT @resultCode AS 'resultCode', @resultMsg AS 'resultMsg';";
			$resultB = $WBD->query($sqlB);
			if ( $WBD->error() == '' ) {
				$row = mysqli_fetch_assoc($resultB);
				$rCode = $row["resultCode"];
				$rMsg = $row["resultMsg"];
				if ( $rCode == 0 ) {
					echo json_encode(array( "codigo" => 0, "mensaje" => utf8_encode("Cuenta guardada exitosamente.") ));
					exit();
				} else {
					echo json_encode(array( "codigo" => 500, "mensaje" => $rMsg ));
					exit();
				}						
			} else {
				echo json_encode(array( "codigo" => 504, "mensaje" => utf8_encode("No es posible guardar cuenta. Por favor contacte a Soporte. Error: ".$WBD->error()) ));
				exit();				
			}		
		} else {
			echo json_encode(array( "codigo" => 501, "mensaje" => utf8_encode("No es posible guardar cuenta. Por favor contacte a Soporte. Error: ".$WBD->error()) ));
			exit();		
		}
	}
?>