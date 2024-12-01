<?php 
	include("conf.inc.php");
	
	#$errorTrack	 = (isset($_GET['error']))?($_GET['error']):(0);
	#$Autorizador = (isset($_GET['Autorizador']))?($_GET['Autorizador']):(0);
	#$IP			 = (isset($_GET['ip']))?($_GET['ip']):(0);

	$Autorizador = (isset($_GET['Autorizador']))?($_GET['Autorizador']):(1000);
	$errorTrack = (isset($_GET['error']))?(str_replace(DELIM," ",$_GET['error'])):('N/A');
	$IP 		= (isset($_GET['ip']))?(str_replace(DELIM," ",$_GET['ip'])):('N/A');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Error</title>
<style type="text/css">
<!--
.style1 {color: #003366}
-->
</style>
</head>

<body>
<h3 align="center" class="style1">Notificacion de Error</h3>
      <p align="center">Se ha registrado un error en: <br />
      <?php echo $errorTrack; ?></p>
      <p align="center"> Fecha y Hora: <?php echo date("d/m/Y H:i:s"); ?> </p>
      <p align="center">Servidor: <?php echo $Autorizador; ?><br />
      Cliente: <?php echo $IP; ?></p>
    <p>&nbsp;</p>
</body>
</html>
