<!--REPORTE DE COMISIONES...-->
<style>
.rep{
font-weight:bold;
color:green;
}
.raya{
border-bottom:1px solid #00f;
}
.raya2{
border-top:1px solid #00f;
}
.a{
width:10px;
}
.c{
width:130px;
}
.e{
width:40px;
}
.g{
width:40px;
}
</style>
<?php
if(isset($_POST['corresponsal']) && isset($_POST['fecha'])){
$cadena = $_POST['cadena'];
$subcadena = $_POST['subcadena'];
$corresponsal = $_POST['corresponsal'];
$fechainicio = $_POST['fechainicio'];
$fechafinal = $_POST['fechafinal'];
$estado = $_POST['estado'];
}

header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=archivoExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");




$d = "<table border='0'>";
for($i=0;$i<2;$i++){
$d.="<tr style='text-align:center;'><td class='a' class='rep' colspan='8'>Reporte de Comisiones para Corresponsal </td></tr>";
$d.="<tr style='text-align:center;'><td colspan='8'>periodo de :</td></tr>";
$d.="<tr><td colspan='2'></td><td colspan='5' class='raya2'></td><td></td></tr>";


//TELEFONIA
$d.="<tr style='font-weight:bold;'><td colspan='2'>Telefonia $i</td><td class='c'></td><td>Movimientos</td><td class='e'></td><td>Importe</td><td class='g'></td><td>Comisi&oacute;n T.</td></tr>";

$d.="<tr><td class='a'></td><td class='raya'>Tiempo Aire</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";
//incluir las de tiempo aire

$d.="<tr><td class='a'></td><td class='raya'>Larga Distancia</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";
//incluir las de larga distancia
$d.="<tr><td class='a'></td><td class='raya'>Datos</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";
//incluir las de datos

$d.="<tr><td class='a'></td><td class='raya'>Mensajes SMS</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";
//incluir las de sms


//SERVICIOS
$d.="<tr style='font-weight:bold;'><td colspan='2'>Servicios</td><td></td><td>Movimientos</td><td class='e'></td><td>Importe</td><td class='g'></td><td>Comisi&oacute;n T.</td></tr>";
$d.="<tr><td class='a'><td class='raya'>Pago de Servicios</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";


//BANCOS
$d.="<tr style='font-weight:bold;'><td colspan='2'>Bancos</td><td></td><td>Movimientos</td><td class='e'></td><td>Importe</td><td class='g'></td><td>Comisi&oacute;n T.</td></tr>";
$d.="<tr><td class='a'><td class='raya'>Servicios Bancarios</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";
$d.="<tr><td class='a'><td class='raya'>Pago de Cr&eacute;ditos</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";


//TRANSPORTE
$d.="<tr style='font-weight:bold;'><td colspan='2'>Transporte</td><td></td><td>Movimientos</td><td class='e'></td><td>Importe</td><td class='g'></td><td>Comisi&oacute;n T.</td></tr>";
$d.="<tr><td class='a'></td><td class='raya'>Boletos de Autobus</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";


//REMESAS
$d.="<tr style='font-weight:bold;'><td colspan='2'>Remesas</td><td></td><td>Movimientos</td><td class='e'></td><td>Importe</td><td class='g'></td><td>Comisi&oacute;n T.</td></tr>";
$d.="<tr><td class='a'></td><td class='raya'>Cobro de Remesas</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";
$d.="<tr><td class='a'></td><td class='raya'>Env&iacute;o de Remesas</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";


//SEGUROS
$d.="<tr style='font-weight:bold;'><td colspan='2'>Seguros</td><td></td><td>Movimientos</td><td class='e'></td><td>Importe</td><td class='g'></td><td>Comisi&oacute;n T.</td></tr>";
$d.="<tr><td class='a'></td><td class='raya'>Seguros de Auto</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";
$d.="<tr><td class='a'></td><td class='raya'>MicroSeguros</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";


//JUEGOS
$d.="<tr style='font-weight:bold;'><td colspan='2'>Juegos</td><td></td><td>Movimientos</td><td></td class='e'><td>Importe</td><td class='g'></td><td>Comisi&oacute;n T.</td></tr>";
$d.="<tr><td class='a'></td><td class='raya'>Multijuegos</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";
$d.="<tr><td class='a'></td><td class='raya'>Pronosticos</td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td><td class='raya'></td></tr>";




$d.="<tr style='height:40px;'></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
//TOTALES
$d.="<tr style='text-align:right;font-weight:bold;'></td><td></td><td></td><td>Total</td><td>0</td><td></td><td>$0.00</td><td></td><td>$0.00</td></tr>";

$d.="<tr style='height:320px;'></td><td></td><td colspan='5'></td><td></td><td></td></tr>";
}

$d.="</table>";
	//$d = "<table><tr><td style='width:200px;'>A</td><td>B</td><td style='background-color:red;'>C</td></tr><tr><td>a</td><td>b</td><td>c</td></tr></table>";
	echo $d;
?>

