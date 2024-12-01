<?php
session_start();
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	
	$tipoMovimiento = (isset($_POST['tipoMovimiento']))? $_POST['tipoMovimiento'] : -1;
	$tipoInstruccion = (isset($_POST['tipoInstruccion']))? $_POST['tipoInstruccion'] : -1;
	$numeroCuenta = (isset($_POST['numeroCuenta']))? $_POST['numeroCuenta'] : NULL;
	$beneficiario = (isset($_POST['beneficiario']))? $_POST['beneficiario'] : -1;
	$RFC = (isset($_POST['RFC']))? $_POST['RFC'] : -1;
	$correo = (isset($_POST['correo']))? $_POST['correo'] : -1;
	$idConfiguracion = (isset($_POST['idConfCuenta']))? $_POST['idConfCuenta'] : -1;
	$idConfCuentaBanco = (isset($_POST['idConfCuentaBanco']))? $_POST['idConfCuentaBanco'] : -1;
	$referencia = (isset($_POST['referencia']))? $_POST['referencia'] : -1;
	$CLABE = (isset($_POST['CLABE']))? $_POST['CLABE'] : -1;
	$idEmpleado = $_SESSION['idU'];
	
		
	$RFC = strtoupper($RFC);
	$beneficiario = utf8_decode($beneficiario);
	
	
		//detectar si la clabe se cambió, consulto la clabe actual en la tabla antes de ser cambiada
				$sql = "SELECT CLABE FROM data_contable.conf_cuenta_banco
						WHERE id = '$idConfCuentaBanco'";

				$result = $RBD->query($sql);
			
				$errmsg = $RBD->error();
				
				while($row= mysqli_fetch_assoc($result)){
					$CLABE_consultada	= $row['CLABE'];
				}
				
	//comparo si la clabe guardada en la tabla coincide con la clabe que viene del formulario
	if($CLABE == $CLABE_consultada){
	
	$sqlC = "CALL `data_contable`.`SP_EDITAR_CUENTA_CONF`($idConfiguracion, $tipoInstruccion, $tipoMovimiento, $idConfCuentaBanco, '$beneficiario', '$RFC', '$referencia', '$correo', $idConfCuentaBanco,'$CLABE',$idEmpleado);";
	$resultC = $WBD->SP($sqlC);
	if ( $WBD->error() == '' ) {
		echo json_encode(array( "codigo" => 0, "mensaje" => utf8_encode("Configuración guardada exitosamente.") ));
		exit();
	} else {
		echo json_encode(array( "codigo" => 502, "mensaje" => utf8_encode("No es posible guardar configuración. Por favor contacte a Soporte. Error: ".$WBD->error()) ));
		exit();
	}
	
} else {

				//update solo al estatus = 3
				$sql = "UPDATE data_contable.conf_cuenta_banco
						SET idEstatus = '3'
						WHERE id = '$idConfCuentaBanco'";

				$result = $WBD->query($sql);
			
				$errmsg = $WBD->error();
				
				//update en tabla conf_cuenta
				$sql = "UPDATE data_contable.conf_cuenta
						SET idEstatus = '3'
						WHERE idConfCuenta = '$idConfCuentaBanco'";

				$result = $WBD->query($sql);
			
				$errmsg = $WBD->error();
				
				
//agregar nuevo renglon con toda la info nueva en pantalla y el estatus = 0
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