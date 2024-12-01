<?php
#########################################################
#
#Codigo PHP
#

//force the browser to use ssl (STRONGLY RECOMMENDED!!!!!!!!)
if ($_SERVER["SERVER_PORT"] != 443) {
	header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
	exit();
}

session_start();
include("inc/config.inc.php");

if (isset($_SESSION['MiSuerte'])) {
	if ($IP == $_SESSION['sip']) {
		header('Location: ./main.php');
		exit;
	} else {
		header('Location: ./logout.php');
		exit;
	}
}

if (isset($_POST['txtUser']) && isset($_POST['txtPass']) || isset($_POST['LOGIN'])) {	//1
	$USER = new User($LOG, $RBD);
	$PERM = new Permisos($LOG, $RBD);
	$PORT = new Portal($LOG, $RBD);

	$USUARIO  = $_POST['txtUser'];
	$PASSWORD = $_POST['txtPass'];

	$Result	= $USER->Login($USUARIO, $PASSWORD);

	//echo var_export($Result, true);

	//echo var_export($USER->getUserCorreo(), true);

	if ($Result['codigoRespuesta'] == 0) {

		$USER->setSessionId(session_id());
		
		$_SESSION['MiSuerte'] 		= true;
		$_SESSION['userName']	= $USER->getUserName();
		$_SESSION['email']		= $USER->getUserCorreo();
		$_SESSION['idU']		= $USER->getIdUser($_SESSION['email']);
		$_SESSION['idU']		= isset($_SESSION['idU']) ? $_SESSION['idU'] : -2;
		$_SESSION['nombre']		= $USER->getUserNombre();
		
		//echo var_export($USER, true);

		//echo var_export($USER->getEstatus($_SESSION['idU']), true);
		
		
		if ($USER->getEstatus($_SESSION['idU']) == 0) {
			if ($_SESSION['MiSuerte']) {
				$PORTAL = "Mi Suerte";
				$Result = $PORT->getIDPortal($PORTAL);
				//echo var_export($Result, true);
				if ($Result['codigoRespuesta'] == 0) {
					$_SESSION['idPortal'] = $PORT->idPortal;
				}
			}

			//echo var_export($_SESSION['idU'], true);

			if ($_SESSION['idU'] == -2) {
				header('Location: index.php?5');
				session_destroy();
				exit;
			}

			//echo var_export($_SESSION['email']."-". $_SESSION['idPortal'], true);

			$_SESSION['idPerfil']	= $USER->getIdPerfil($_SESSION['email'], $_SESSION['idPortal']);
			$_SESSION['name']		= $USER->getUserNombre();
			$_SESSION['sip']		= $IP;
			$_SESSION['pass']		= $PASSWORD;

			///ASIGNAR PERMISOS A VARIABLE DE SESION PERM
			if ($_SESSION['idPerfil'] != -1) {
				//echo var_export('<h1>entra para permisos</h1>', true);
				$RES = $PERM->getPermisos($_SESSION['idU'], $_SESSION['idPerfil'], $_SESSION['idPortal']);
				$_SESSION['Permisos'] = $RES['data'];
			}

			header('Location: main.php');
			exit;
		} else {
			$LOG->error("Falla Login Corresponsal : " . $USUARIO . ':' . $PASSWORD);
			header('Location: index.php?' . $Result['codigoRespuesta']);
			exit;
		}
	} else {
		$LOG->error("Falla Login Corresponsal : " . $USUARIO . ':' . $PASSWORD);
		header('Location: index.php?' . $Result['codigoRespuesta']);
		exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<META http-equiv="Content-Type" content="text/html; charset=Windows-1252">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<meta charset="UTF-8">
	<meta name="robots" content="all" />
	<title>Mi Red</title>
	<link rel="shortcut icon" href="img/favicon.ico">

	<link href="css/RE-CSS-Log-In.css" rel="stylesheet" type="text/css" />
	<script src="inc/js/font.js" type="text/javascript" language="JavaScript"></script>
	<script src="inc/js/functions.js" type="text/javascript" language="JavaScript"></script>
	<!--script src="js/jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script-->
	<script src="inc/js/jquery-1.5.1.min.js" type="text/javascript"></script>
	<script src="inc/js/log-in.js" type="text/javascript"></script>
	<SCRIPT language="JavaScript">
		function submitform() {
			//document.Login.txtPass.value = MD5(document.Login.txtPass.value);
			document.Login.submit();
		}

		$(document).ready(function() {
			document.Login.txtUser.focus();
		})
	</SCRIPT>
</head>

<body>
	<div class="frontpage">
		<div class="login">
			<div class="form"><img src="img/mired.png">

				<form id="Login" name="Login" method="post" action="index.php" onsubmit="submitform()">

					<div id="div-usuario" class="ctrls">
						<input type="text" id="txtUser" name="txtUser" class="rectrls" onfocus="cambio('div-usuario','div-password');" onclick="cambio('div-usuario','div-password');" onkeypress="Borrar('txtUser')" value="Usuario" />
					</div>



					<div id="div-password" class="ctrls">
						<input type="password" id="txtPass" name="txtPass" class="rectrls" onfocus="cambio('div-password','div-usuario');	" onclick="cambio('div-password','div-usuario');" onkeypress="Borrar('txtPass')" value="~~~~~~~" />

						<input type="submit" name="LOGIN" class="botonAcceso" value="" />
						<!--button id="botonAcceso" ></button-->
					</div>
					<table>
						<tr>
							<td>
								<div class="Error" id="divError">
									<?php
									if (isset($_GET['1'])) {
										echo 'Contrase&ntilde;a incorrecta';
									}
									if (isset($_GET['2'])) {
										echo 'Usuario y/o Contrase&ntilde;a incorrectos';
									}
									if (isset($_GET['3'])) {
										echo 'Contrase�a vacia, favor de introducirla';
									}
									if (isset($_GET['4'])) {
										echo 'El Usuario Esta vacio, favor de introducirlo';
									}
									if (isset($_GET['5'])) {
										echo 'El Usuario No Existe en el Sistema';
									}
									if (isset($_GET['6'])) {
										echo 'El Usuario No tiene permisos de acceso para este Sistema';
									}
									?>
								</div>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="footer">
		Mi Red. Sistema de Administraci&oacute;n Integral de Red Efectiva. Derechos reservados 2013.</div>

</body>

</html>