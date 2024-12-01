<?php
$pemiso		= (isset($_POST['pemiso']))?$_POST['pemiso']: false; if($pemiso){

include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $RBD;

$idEmpleado			= $_SESSION['idU'];
$nombreProveedor	= $_POST["txtNombreProveedor"];
$razonSocial		= $_POST["txtRazonSocial"];
$rfc				= $_POST["txtRFC"];
$clabe				= $_POST["txtCLABE"];
$telefono			= $_POST["txtTelefono"];
$correo				= $_POST["txtCorreo"];

$sql = "CALL redefectiva.SP_ACREEDOR_CREAR('$idEmpleado'," 
		. "'$nombreProveedor','$razonSocial', '$rfc','$clabe','$telefono',"
		. "'$correo')";
$result = $RBD->SP($sql);
//echo $result;
if($RBD->error() == '') {
	$RES = "";
	if(mysqli_num_rows($result) > 0){
		while($row= mysqli_fetch_assoc($result)) {

			if($row["CodigoRespuesta"] == 0 && $row["MsgRespuesta"] == "Alta Exitosa.") {
					$RES = "0|El Proveedor ha sido dado de alta satisfactoriamente|"
							. $row["idProveedor"] . "|" . $nombreProveedor ;
			}
			else {
				if(!$RES) $RES = "1|";
				$RES .= $row["MsgRespuesta"] . "\n";
			}
		}
	} else { $RES .= '2|No se Encontraron datos del Proveedor';}	
} else { $RES .= '3|Error en query: '. $sql . $RBD->error();}	

//$RES = print_r($_POST,true) . $sql;
//$RES = print_r($_POST,true);
exit($RES);
}
?>