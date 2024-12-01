<?php 
	include("conf.inc.php");
	$NOMCOR = (isset($_GET['nombre']))?(str_replace(DELIM," ",$_GET['nombre'])):('N/A');
	$NUMCOR = (isset($_GET['numero']))?(str_replace(DELIM," ",$_GET['numero'])):('N/A');
	$FORE 	= (isset($_GET['forelo']))?($_GET['forelo']):(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
<title>Notificacion de Forelo</title>
<style type="text/css">
<!--
.style1 {color: #003366}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>

<body>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><h3 align="center" class="style1"><img src="http://www.redefectiva.com/img/logo.gif" alt="Red Efectiva" width="250" height="100" /><br />
    Suspenci&oacute;n de Servicio por falta de FORELO</h3>
      <p align="center">Fecha y Hora: <?php echo date("d/m/Y H:i:s"); ?> </p>
      <p align="center"><strong><?php echo $NOMCOR; ?></strong><br />
          <strong><?php echo $NUMCOR; ?></strong><br />
          <strong>FORELO al <?php echo $FORE; ?> %</strong></p>
      <p>Estimado Corresponsal, le informamos que ya no puede realizar operaciones debido que su saldo se encuentra por debajo del saldo operacional. </p>
      <p>Lo invitamos a restituir su saldo lo antes posible para que pueda continuar  ofreciendo el servicio a sus clientes.</p>
      <p>Una vez realizado el dep&oacute;sito en el Banco, le pedimos lo registre   a trav&eacute;s del &quot;<a href="https://www.redefectiva.net/corresponsal">Sistema de Administración</a>&quot; en la secci&oacute;n &quot;Dep&oacute;sitos&quot; para que este sea aplicado a la brevedad. As&iacute; como tambi&eacute;n le pedimos se comunique con Red Efectiva al 01-81-8356-2600 para notificar  su dep&oacute;sito.</p>
      <p>Recuerde que si el dep&oacute;sito es efectuado entre 2:00 PM y 4:00 PM, este ser&aacute; aplicado despu&eacute;s de las 4:15 PM, de igual manera si este es registrado despu&eacute;s de las 7:30 PM ser&aacute; aplicado al d&iacute;a siguiente.</p>
      <p>Para m&aacute;s informaci&oacute;n favor de comunicarse a Red Efectiva o contactarnos a la siguiente direcci&oacute;n: <a href="mailto:sleal@redefectiva.com ">sleal@redefectiva.com </a></p>
      <p align="center">Muchas Gracias,</p>
      <p align="center">Atte.</p>
      <p align="center">Red Efectiva</p>
    </td>
  </tr>
</table>
</body>
</html>
