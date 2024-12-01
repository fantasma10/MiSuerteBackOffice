<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
	
	$idConfiguracion = (isset($_POST['idConfiguracion']))? $_POST['idConfiguracion'] : -1;
	
	$sql = "CALL `data_contable`.`SP_ELIMINAR_CUENTACONFIGURACION`($idConfiguracion);";
	$result = $WBD->query($sql);
	if ( $WBD->error() == "" ) {
		echo json_encode(array( "codigo" => 0, "mensaje" => "Cuenta eliminada exitosamente." ));
		exit();
	} else {
		echo json_encode(array( "codigo" => 501, "mensaje" => "No fue posible eliminar configuracion. Por favor contacte a Soporte. Error: ".$WBD->error() ));
		exit();
	}
?>
