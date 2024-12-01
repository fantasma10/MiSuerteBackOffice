<?php 
$numCuenta = (isset($_GET['numCuenta']))?($_GET['numCuenta']):(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {color: #003366}
-->
</style>
</head>

<body>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><h3 align="center" class="style1">Notificacion de Deposito</h3>
      <p align="center">Se ha registrado un deposito al numero de cuenta: <?php echo $numCuenta; ?></p>
      <p align="center"> Fecha y Hora: <?php echo date("d/m/Y H:i:s"); ?> </p>
      <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
