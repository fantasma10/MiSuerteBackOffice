<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$usuario_logueado = $_SESSION['idU'];

	$nIdDiferencia	 = !empty($_POST['nIdDiferencia'])	? $_POST['nIdDiferencia'] : 0;
	$nIdAutorizacion = $_POST['nIdAutorizacion'];
	$nIdEstatus      = 0;

	if (in_array($usuario_logueado, $usuarios_contabilidad_diferencias['usuarios_conciliador'])) {
		// Autorizacion en espera
		$nIdEstatus = 2;
	}
	elseif (in_array($usuario_logueado, $usuarios_contabilidad_diferencias['usuarios_contralor'])) {
		if ($nIdAutorizacion == -1) {
			// Autorizacion rechazada
			$nIdEstatus = 0;
		} else {
			// Autorizacion completada
			$nIdEstatus = 1;
		}
	}

	$oConciliacionDiferencia = new ConciliacionDiferencia();
	$oConciliacionDiferencia->setNId($nIdDiferencia);
	$oConciliacionDiferencia->setORdb($oRdb);

	$resultado = $oConciliacionDiferencia->actualizar_estatus_autorizacion($nIdEstatus, $nIdAutorizacion, $usuario_logueado);

	echo json_encode(array(
		"sEcho"					=> intval($_POST['sEcho']),
		"bExito"				=> $resultado['bExito'],
		"nCodigo"				=> $resultado['nCodigo'],
        "sMensaje"              => $resultado['sMensaje']
	));

?>