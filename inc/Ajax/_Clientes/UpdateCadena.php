<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $WBD;

$cadena				= (isset($_POST['cadena']))?$_POST['cadena']: NULL;
$grupo				= (isset($_POST['grupo']))? $_POST['grupo'] : NULL;
$nombreCadena 		= (isset($_POST['nombreCadena']))? $_POST['nombreCadena'] : NULL;
$giro				= (!empty($_POST['giro']))? $_POST['giro'] : 0;
$estatus			= (isset($_POST['estatus']))? $_POST['estatus'] : NULL;
$telefono			= (isset($_POST['telefono']))? $_POST['telefono'] : NULL;
$correo				= (isset($_POST['correo']))? $_POST['correo'] : NULL;
$idEjecutivo		= (isset($_POST['idEjecutivo']))?$_POST['idEjecutivo']: 0;
$idEjecutivoVenta	= (isset($_POST['idEjecutivoVenta']))?$_POST['idEjecutivoVenta']: 0;
$idReferencia		= (isset($_POST['idReferencia']))?$_POST['idReferencia']: 0;
$tipoCliente		= (isset($_POST['idTipoCliente']))?$_POST['idTipoCliente']: 0;
$deletePermisos		= (isset($_POST['deletePermisos']))? $_POST['deletePermisos'] : 0;
$idGrupoOriginal	= (!empty($_POST['idGrupoOriginal']))? $_POST['idGrupoOriginal'] : 0;

$telefono = str_replace("-", "", $telefono);

if($deletePermisos == 'true'){
	$idUsuario = $_SESSION["idU"];
	$sql = $WBD->query("CALL `redefectiva`.`SP_DROP_PERMISOS_POR_CADENA`($idGrupoOriginal, $cadena, 0, $idUsuario);");
	$row = mysql_fetch_assoc($sql);

	if($WBD->error()){
		$RES = "0|No ha sido Posible Cambiar el Grupo de la Cadena";
		echo $RES;
		//echo $WBD->error();
		return false;
	}
	else{
		$sql = $WBD->query("CALL `redefectiva`.`SP_UPDATE_GRUPO`($grupo, $cadena)");

		if($WBD->error()){
			$RES = "1|No ha sido Posible Cambiar el Grupo de la Cadena".$WBD->error();
			echo $RES;
			return false;
		}
	}
}

$sql = "CALL `redefectiva`.`SP_UPDATE_CADENA`($cadena, '{$_SESSION['idU']}', $grupo, $giro, '$nombreCadena', '$telefono', '$correo', $estatus, $idReferencia);";
$result = $WBD->SP($sql);
$RES = '';

if ( $WBD->error() == '' ) {
	$RES = "0|Se ha actualizado correctamente la cadena";

	if ( $idEjecutivo > 0 ) {
		$FROM = "";		$WHERE = "";	$INSERT = "";
		if ( $tipoCliente == 1 ) {
			$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOCADENA`($cadena, 5);";
			$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOCADENA`($cadena, $idEjecutivo, {$_SESSION['idU']}, _IDCADENAEJECUTIVO_);";
			$fecVigen = date('Y-m-d', strtotime('+10 Year'));
			$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOCADENA`($cadena, $idEjecutivo, '$fecVigen', {$_SESSION['idU']}, 5);";
		}

		if ( $tipoCliente == 2 ) {
			$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOSUBCADENA`($cadena);";
			$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOSUBCADENA`($cadena, $idEjecutivo, {$_SESSION['idU']});";
			$fecVigen = date('Y-m-d', strtotime('+10 Year'));
			$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOSUBCADENA`($cadena, $idEjecutivo, '$fecVigen', {$_SESSION['idU']}, 5);";
		}

		if ( $tipoCliente == 3 ) {
			$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOCORRESPONSAL`($cadena);";
			$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOCORRESPONSAL`($cadena, $idEjecutivo, {$_SESSION['idU']});";
			$fecVigen = date('Y-m-d', strtotime('+10 Year'));
			$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOCORRESPONSAL`($cadena, $idEjecutivo, '$fecVigen', {$_SESSION['idU']}, 5);";
		}

		$RES = '';
		if ( $tipoCliente > 0 ) {
			$RESsql = $RBD->SP($sql);	

			if ( mysqli_num_rows($RESsql) > 0 ) {

				$row = mysqli_fetch_assoc($RESsql);

				$arrReplace = array('_IDEJECUTIVO_', '_IDCADENAEJECUTIVO_');
				$arrReplacements = array($row["idEjecutivo"], $row["idCadenaEjecutivo"]);

				$sql2 = str_replace($arrReplace, $arrReplacements, $sql2);
				$WBD->SP($sql2);
				if ( $WBD->error() == '' ) {
					$RES = "0|Se ha actualizado correctamente la cadena";
				} else {
					$RES = "2|Error al asignar el ejecutivo".$sql2." ".$WBD->error();
				}
				
			} else {
		
				$WBD->SP($sql3);
				if ( $WBD->error() == '' ) {
					$RES = "0|Se ha actualizado correctamente la cadena";
				} else {
					$RES = "1|Error al asignar el ejecutivo".$sql3." ".$WBD->error();	
				}
			}
						
		}
	}

	if ( $idEjecutivoVenta > 0 ) {
		$FROM = "";		$WHERE = "";	$INSERT = "";

		if ( $tipoCliente == 1 ) {
			$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOCADENA`($cadena, 2);";
			$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOCADENA`($cadena, $idEjecutivoVenta, {$_SESSION['idU']}, _IDCADENAEJECUTIVO_);";
			$fecVigen = date('Y-m-d', strtotime('+10 Year'));
			$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOCADENA`($cadena, $idEjecutivoVenta, '$fecVigen', {$_SESSION['idU']}, 2);";
		}

		if ( $tipoCliente == 2 ) {
			$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOSUBCADENA`($cadena, $idEjecutivoVenta);";
			$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOSUBCADENA`($cadena, $idEjecutivoVenta, {$_SESSION['idU']});";
			$fecVigen = date('Y-m-d', strtotime('+10 Year'));
			$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOSUBCADENA`($cadena, $idEjecutivoVenta, '$fecVigen', {$_SESSION['idU']}, 2);";
		}

		if ( $tipoCliente == 3 ) {
			$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOCORRESPONSAL`($cadena);";
			$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOCORRESPONSAL`($cadena, $idEjecutivoVenta, {$_SESSION['idU']});";
			$fecVigen = date('Y-m-d', strtotime('+10 Year'));
			$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOCORRESPONSAL`($cadena, $idEjecutivoVenta, '$fecVigen', {$_SESSION['idU']}, 2);";
		}
		
		
		$RES = '';
		if ( $tipoCliente > 0 ) {
		
			$RESsql = $RBD->SP($sql);	
			
			if ( mysqli_num_rows($RESsql) > 0 ) {

				$row = mysqli_fetch_assoc($RESsql);

				$arrReplace = array('_IDEJECUTIVO_', '_IDCADENAEJECUTIVO_');
				$arrReplacements = array($row["idEjecutivo"], $row["idCadenaEjecutivo"]);
				$sql2 = str_replace($arrReplace, $arrReplacements, $sql2);
				$WBD->SP($sql2);
				if ( $WBD->error() == '' ) {
					$RES = "0|Se ha actualizado correctamente la cadena";
				} else {
					$RES = "2|Error al asignar el ejecutivo".$sql2." ".$WBD->error();
				}
				
			} else {
		
				$WBD->SP($sql3);
				if ( $WBD->error() == '' ) {
					$RES = "0|Se ha actualizado correctamente la cadena";
				} else {
					$RES = "1|Error al asignar el ejecutivo".$sql3." ".$WBD->error();	
				}
			}
						
		}
	}	
	
} else {
	$RES = "2|".$WBD->error();
}

echo $RES;
		
?>