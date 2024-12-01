<?php
	
	$permiso = (isset($_POST['permiso']))?$_POST['permiso']: false;
	include("../../config.inc.php");
	include("../../session.ajax.inc.php");
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	if($permiso){
		$datosGenerales		= json_decode(stripcslashes($_POST['datosGenerales']), true);
		$permisos			= json_decode(stripcslashes($_POST['permisos']), true);

		$idUsuario			= $datosGenerales['datosGenerales'][0]['idUsuario'];
		$idPerfil			= $datosGenerales['datosGenerales'][0]['idPerfil'];
		$apellidoMaterno	= $datosGenerales['datosGenerales'][0]['apellidoMaterno'];
		$apellidoMaterno	= utf8_decode($apellidoMaterno);
		$idEstatus			= $datosGenerales['datosGenerales'][0]['idEstatus'];
		$idPerfil			= $datosGenerales['datosGenerales'][0]['idPerfil'];
		$idPortal			= $datosGenerales['datosGenerales'][0]['idPortal'];
		$idPerfilOriginal	= $datosGenerales['datosGenerales'][0]['idPerfilOriginal'];
		
		
		$RES = '';
		$RES = array('nCodigo' => "0", 'sMensaje' => "Datos Actualizados Correctamente");
		
		$sql = "UPDATE `data_acceso`.`dat_usuario`
		SET `apellidoMaterno` = '$apellidoMaterno',
		`idEstatus` = $idEstatus
		WHERE `idUsuario` = $idUsuario;";
		$WBD->query($sql);
		if ( $WBD->error() != '' ) {
			$RES = array('nCodigo' => "2", 'sMensaje' => $WBD->error() . " linea 32");
		} else {
			#echo "Actualizo apellido materno\n";
		}
		
		$ban = true;

		for($permisoIndex = 0; $permisoIndex < count($permisos['Menu']); $permisoIndex++){
			$idOpcion = $permisos['Menu'][$permisoIndex]['idOpcion'];
			$idAccion = $permisos['Menu'][$permisoIndex]['idAccion'];

			$sql = "SELECT `idPermiso`
			FROM `data_acceso`.`inf_permisos`
			WHERE `idUsuario` = -1
			AND `idAccion` = $idAccion
			AND `idOpcion` = $idOpcion
			AND `idPerfil` = $idPerfil
			AND `idPortal` = $idPortal";
			$RESsql = $WBD->query($sql);
			if($permisoIndex < 1){
				$num_rows = mysqli_num_rows($RESsql);
				$LOG->error("$sql  num_rows $num_rows . linea 42",false);
			}

			if (mysqli_num_rows($RESsql) == 0 ) {
				$sql = "SELECT `idPermiso`
				FROM `data_acceso`.`inf_permisos`
				WHERE `idUsuario` = $idUsuario
				AND `idOpcion` = $idOpcion
				AND `idPerfil` = $idPerfil
				AND `idPortal` = $idPortal;";
				$RESsql = $WBD->query($sql);
				if($permisoIndex < 1){
					$num_rows = mysqli_num_rows($RESsql);
					$LOG->error("$sql  num_rows $num_rows . linea 56",false);
				}
				if (mysqli_num_rows($RESsql) == 1 ){
					$row = mysqli_fetch_array($RESsql, MYSQLI_ASSOC);
					$idPermiso = $row['idPermiso'];
					$sql = "UPDATE `data_acceso`.`inf_permisos`
							SET `idAccion` = $idAccion
							WHERE `idPermiso` = $idPermiso;";
					if($permisoIndex < 1){
						$LOG->error("$sql linea 70",false);
					}
					$WBD->query($sql);
					if ( $WBD->error() == '' ) {
						$RES = array('nCodigo' => "0", 'sMensaje' => 'Se ha actualizado correctamente');
					} else {
						$RES = array('nCodigo' => "2", 'sMensaje' => $WBD->error() . " linea 74");
					}
				}else if( mysqli_num_rows($RESsql) == 0  ){
					$sql = "INSERT INTO `data_acceso`.`inf_permisos`(`idUsuario`, `idAccion`, `idOpcion`,`idPerfil`, `idPortal`, `idEstatus`,`fechaAlta`, `fechaMovimiento`, `idEmpleado`)
					VALUES ($idUsuario, $idAccion, $idOpcion,$idPerfil, $idPortal, 0,NOW(), NOW(), {$_SESSION['idU']});";
					if($permisoIndex < 1){
						$LOG->error("$sql linea 83",false);
					}
					$WBD->query($sql);
					if ( $WBD->error() == '' ) {
						$RES = array('nCodigo' => "0", 'sMensaje' =>"Se ha actualizado correctamente");
					} else {
						$RES = array('nCodigo' => "2|", 'sMensaje' => $WBD->error() . " linea 84");
					}
				}else{
					if($permisoIndex < 1){	
						$LOG->error("$sql 94 ",false);
					}
				}
			}else{
				if($permisoIndex < 1){
					$num_rows = mysqli_num_rows($RESsql);
					$LOG->error("$sql  num_rows $num_rows . linea 94",false);
				}
				$sql = "SELECT `idPermiso`
				FROM `data_acceso`.`inf_permisos`
				WHERE `idUsuario` = $idUsuario
				AND `idOpcion` = $idOpcion
				AND `idPerfil` = $idPerfil
				AND `idPortal` = $idPortal";
				$RESsql = $WBD->query($sql);
				if ( $WBD->error() == '') {
					$row = mysqli_fetch_array($RESsql, MYSQLI_ASSOC);
					$idPermisoPorBorrar = $row['idPermiso'];
					$sql = "DELETE FROM `data_acceso`.`inf_permisos` WHERE `idPermiso` = $idPermisoPorBorrar";
					$RESsql = $WBD->query($sql);
					if ( $WBD->error() != '' ) {
						$RES = array('nCodigo' => "0", 'sMensaje' => "Se ha actualizado correctamente");
					}
				} else {
					$RES = array('nCodigo' =>"2", 'sMensaje' => "Error al consultar base de datos");
				}

			}
		}
		
		$sql = "SELECT `idPerfilesDelUsuario`
		FROM `data_acceso`.`inf_perfilesdelusuario`
		WHERE `idUsuario` = $idUsuario
		AND `idPortal` = $idPortal";
		$RESsql = $WBD->query($sql);

		if ( mysqli_num_rows($RESsql) > 0 ) {
			$row = mysqli_fetch_array($RESsql, MYSQLI_ASSOC);
			$idPerfilesDelUsuario = $row['idPerfilesDelUsuario'];
		}

		if($idPerfil != -1){
			$sql = "SELECT `idPerfil`
				FROM `data_acceso`.`cat_perfil`
				WHERE `idPerfil` = $idPerfil
				AND `idPortal` = $idPortal
				AND `idEstatus` = 0;";
			$RESsql = $WBD->query($sql);
			
			if ( mysqli_num_rows($RESsql) > 0 ) {
				$sql = "UPDATE `data_acceso`.`inf_perfilesdelusuario`
					SET `idPerfil` = $idPerfil,
					`idPortal` = $idPortal
					WHERE `idPerfilesDelUsuario` = $idPerfilesDelUsuario;";
				$RESsql = $WBD->query($sql);
				if ( $WBD->error() != '' ) {
					$RES = array('nCodigo' => "2", 'sMensaje' => $WBD->error() . " linea 129");
				}
			}
		} else if ( $idPerfil == -1 ) {
			$sql = "UPDATE `data_acceso`.`inf_perfilesdelusuario`
					SET `idPerfil` = $idPerfil,
					`idPortal` = $idPortal
					WHERE `idPerfilesDelUsuario` = $idPerfilesDelUsuario;";
			$RESsql = $WBD->query($sql);
			if ( $WBD->error() != '' ) {
				$RES = array('nCodigo' => "2", 'sMensaje' => $WBD->error() . " linea 139");
			}
		}
	}

	echo json_encode($RES);


?>