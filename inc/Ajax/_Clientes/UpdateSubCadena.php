<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $RBD;
global $WBD;

$subcadena			= (isset($_POST['subcadena']))?$_POST['subcadena']: NULL;
$grupo				= (isset($_POST['grupo']))? $_POST['grupo'] : NULL;
$nombreSubCadena 	= (isset($_POST['nombreSubCadena']))? $_POST['nombreSubCadena'] : NULL;
$giro				= (isset($_POST['giro']))? $_POST['giro'] : NULL;
$estatus			= (isset($_POST['estatus']))? $_POST['estatus'] : NULL;
$idEjecutivo		= (isset($_POST['idEjecutivo']))?$_POST['idEjecutivo']: '';
$tipoCliente		= (isset($_POST['idTipoCliente']))?$_POST['idTipoCliente']: 0;
$idEjecutivoVenta	= (!empty($_POST["idEjecutivoVenta"]))? $_POST["idEjecutivoVenta"] : 0;
$idReferencia		= (!empty($_POST["idReferencia"]))? $_POST["idReferencia"] : 0;
$idVersion      	= (!empty($_POST["idVersion"]))? $_POST["idVersion"] : 0;
$telefono      		= (!empty($_POST["telefono"]))? $_POST["telefono"] : 0;
$correo      		= (!empty($_POST["correo"]))? $_POST["correo"] : 0;
$iva				= (!empty($_POST["iva"]))? $_POST["iva"] : NULL;

$telefono = str_replace("-", "", $telefono);

$oSubCadena = new subcadena($RBD,$WBD);
$oSubCadena->load($subcadena);

$idVersionOriginal	= (!empty($_POST["idVersionOriginal"]))? $_POST["idVersionOriginal"] : 0;

$idUsuario = $_SESSION["idU"];

/*if($idVersionOriginal != $idVersion){
	$idCadena = $oSubCadena->getCadena();
	$sql = $WBD->query("CALL `redefectiva`.`SP_INSERT_PERMISOS_REPOSITORIO`($idCadena, $subcadena, -1, $idVersionOriginal, $idUsuario)");

	if($WBD->error()){
		echo $RES = "1|No fue posible Modificar la Versión";
		return false;
	}
}*/

$sql = "CALL `redefectiva`.`SP_UPDATE_SUBCADENA`($subcadena, {$_SESSION['idU']}, $grupo, $giro, '$nombreSubCadena', $estatus, $idReferencia, $idVersion, '$telefono', '$correo');";
$result = $WBD->SP($sql);

$RES = '';

if ( $WBD->error() == '' ) {

	//$sql = $WBD->query("CALL `redefectiva`.`SP_UPDATE_VERSION_CORRESPONSAL`($subcadena, $idVersion)");
	//if($WBD->error()){echo $WBD->error();}

	//$RES = "0|Se ha actualizado correctamente la subcadena";

	// Actualizar o Crear al Ejecutivo de Cuenta
	if ($idEjecutivo > 0) {
		$FROM = "";		$WHERE = "";	$INSERT = "";
		
		// Buscar al Ejecutivo de Cuenta
		$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOSUBCADENA`($subcadena, 5);";
		$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivo, {$_SESSION['idU']}, _IDSUBCADENAEJECUTIVO_);";
		$fecVigen = date('Y-m-d', strtotime('+10 Year'));
		$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivo, '$fecVigen', {$_SESSION['idU']}, 5);";

		$RES = '';
		$RESsql = $RBD->SP($sql);	

		if (mysqli_num_rows($RESsql) > 0){
			$row = mysqli_fetch_assoc($RESsql);

			$arrReplace = array('_IDSUBCADENAEJECUTIVO_');
			$arrReplacements = array($row["idSubCadenaEjecutivo"]);

			$sql2 = str_replace($arrReplace, $arrReplacements, $sql2);

			$WBD->SP($sql2);

			if ( $WBD->error() == '' ) {
				$RES = "0|Se ha actualizado correctamente la subcadena";
			} else {
				$RES = "2|Error al asignar el ejecutivo ".$sql2." ".$WBD->error();
			}
		} else {
			$WBD->SP($sql3);
			if ( $WBD->error() == '' ) {
				$RES = "0|Se ha actualizado correctamente la subcadena";
			} else {
				$RES = "1|Error al asignar el ejecutivo ".$sql3." ".$WBD->error();	
			}
		}
	}

	// Actualizar o crear al ejecutivo de Venta
	if ( $idEjecutivoVenta > 0 ) {
		$FROM = "";		$WHERE = "";	$INSERT = "";
		
		// Buscar al Ejecutivo de Venta
		$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOSUBCADENA`($subcadena, 2);";
		$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivoVenta, {$_SESSION['idU']}, _IDSUBCADENAEJECUTIVO_);";
		$fecVigen = date('Y-m-d', strtotime('+10 Year'));
		$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOSUBCADENA`($subcadena, $idEjecutivoVenta, '$fecVigen', {$_SESSION['idU']}, 2);";

		$RES = '';
		$RESsql = $RBD->SP($sql);	
		
		if (mysqli_num_rows($RESsql) > 0){
			$row = mysqli_fetch_assoc($RESsql);

			$arrReplace = array('_IDSUBCADENAEJECUTIVO_');
			$arrReplacements = array($row["idSubCadenaEjecutivo"]);

			$sql2 = str_replace($arrReplace, $arrReplacements, $sql2);

			$WBD->SP($sql2);

			if ( $WBD->error() == '' ) {
				$RES = "0|Se ha actualizado correctamente la subcadena";
			} else {
				$RES = "2|Error al asignar el ejecutivo ".$sql2;
			}
		} else {
			$WBD->SP($sql3);
			if ( $WBD->error() == '' ) {
				$RES = "0|Se ha actualizado correctamente la subcadena";
			} else {
				$RES = "1|Error al asignar el ejecutivo ".$sql3." ".$WBD->error();	
			}
		}
						
	}
	
	//var_dump("TEST A");
	if ( isset($iva) ) {
		//var_dump("TEST B");
		if ( $iva > -1 ) {
			//var_dump("TEST C");
			$fecha		= strftime( "%Y-%m-%d", time() );
			$fecha 		= explode("-",$fecha);
			$fecha_en10 = mktime(0,0,0,$fecha[1],$fecha[2],$fecha[0]+10);
			$fecVen 	= date("Y-m-d", $fecha_en10);
			if(!empty($iva)){
				//var_dump("TEST D");
				$sql = $WBD->query("CALL `redefectiva`.`SP_SET_SUBCADENAIVA`($subcadena, $iva, '$fecVen', $idUsuario);");
				//var_dump("TEST E");
				if($WBD->error() != ""){
					echo $RES = "1|".$WBD->error();
				}
			}
		}
	}	
	
} else {
	$RES = "2|".$WBD->error();
}

echo $RES;

?>