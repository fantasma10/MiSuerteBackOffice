<?php 
include("../../../config.inc.php");
include("../../../session.inc.php");


$oOperador		= new Operador($LOG,$RBD,$LOG2,$WBD); 
$oCorresponsal 	= new Corresponsal($LOG,$RBD,$LOG2,$WBD); 

$idEquipo 		= (isset($_GET['idEquipo']))?($_GET['idEquipo']):(2819);
$idCorresponsal = (isset($_GET['idCorresponsal']))?($_GET['idCorresponsal']):(1);
$movimiento 	= (isset($_GET['movimiento']))?($_GET['movimiento']):(0);

$oCorresponsal->load($idCorresponsal);

$nombreCorresponsal = $oCorresponsal->getNombCorr();
$nombreOperador = $oOperador->NOM_COMPLETO;


$SQL_EQ = "	SELECT `idEquipo`, `numEquipo`, `codActivacion`, `equipoActivo`, `equipoHabilitado`, DATE(`fechaActivacion`), DATE(`fechaAccesoUlt`)
					FROM `data_webpos`.`aps_equipo` 
					WHERE `idEquipo` = '$idEquipo'
					ORDER BY `numEquipo` LIMIT 1;";

$result_eq = $RBD->query($SQL_EQ);
list($idEquipo,$numEquipo,$codActivacion,$activo,$habilitado,$fechaActivacion,$fechaAcceso) = mysqli_fetch_array($result_eq);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimiento Equipo</title>
<style>
	.Titulo2 {
		font-size: 16px;
		font-family: Calibri;
		color: #000066;
		font-weight: bold;
	}
	.Titulo22 {
		font-size: 16px;
		font-family: Calibri;
		color:  #006600;/*003300*/
		font-weight: bold;
	}
	.TituloPeqGf{
		font-size: 13px;
		font-family: Calibri;
		color: #333333;
		font-weight: bold;
	}
	.TituloPeqR{
		font-size: 13px;
		font-family: Calibri;
		color: #990000;
		font-weight: bold;
	}
	.TituloPeqA{
		font-size: 13px;
		font-family: Calibri;
		color: #000066;
		font-weight: bold;
	}
</style>
</head>

<body style="background-color:#FFFFFF">
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="Titulo2">Notificación de Alta de Equipo<br /><br /></td>
  </tr>
  <tr>
  	<td align="center" class="TituloPeqGf">
    	El equipo <span class="Titulo22"><?php echo ' '.$numEquipo.' - '.$idEquipo.' '; ?></span>de la sucursal<br />
        <span class="Titulo22"><?php echo ' '.$nombreCorresponsal.' '; ?></span>, se <span class="TituloPeqR">ha creado exitosamente.</span>
        <br /><br />
    </td>
  </tr>
  <tr>
  	<td align="center" class="TituloPeqGf">Fecha y Hora: <span class="TituloPeqA"><?php echo date("d/m/Y H:i:s"); ?></span></td>
  </tr>
</table>
</body>
</html>
