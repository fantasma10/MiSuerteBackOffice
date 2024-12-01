<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
header( 'Content-Type: text/html;charset=utf-8' );
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$seccion = "Sucursales";

$cabeceras = array("Id","Nombre","Version","Estado","Ciudad","Direccion","Telefono");
//codigo del departamento
$departamento = "DCM";
//tipo de documento
$tipodocumento = "IF";
//consecutivo del documento
$consecutivo = "01";

include("../../../tcpdf/PDFP.php");

$lblEstado			= (!empty($_POST['lblEstado']))?$_POST["lblEstado"]:"";
$lblVersion 		= (!empty($_POST['lblVersion']))?$_POST["lblVersion"]:"";

$todos  			= (isset($_POST['buscatodo']))?$_POST['buscatodo']:0;
$estado  			= (isset($_POST['estado']))?$_POST['estado']:0;

$version 			= (isset($_POST['version']))?$_POST['version']:0;
$numDias			= (!empty($_POST['numDiasPDF']))? $_POST['numDiasPDF'] : -1;
$numOperaciones		= (!empty($_POST['numOpSucursalPDF']))? $_POST['numOpSucursalPDF'] : -1;
$tipoBusqueda		= (isset($_POST['tipoBusquedaPDF']))? $_POST['tipoBusquedaPDF'] : '';
$cant    			= (isset($_POST['cant']))?$_POST["cant"]:20;
$actual  			= (!empty($_POST['actual']))?$_POST["actual"]:0;
	
if ( !empty($todos) ) {
	$actual = 0;
} else {
	$actual = ($actual != "undefined")? $actual : 0;
	if ( $actual > 0 ) {
		$actual = $actual * $cant - $cant;
	}	
}

if ( $cant >= 100 ) {
	$sql = "CALL `redefectiva`.`SP_BUSCA_SUCURSALES`($estado, $version, $numDias, $numOperaciones, '$tipoBusqueda', $actual, 100);";
} else {
	$sql = "CALL `redefectiva`.`SP_BUSCA_SUCURSALES`($estado, $version, $numDias, $numOperaciones, '$tipoBusqueda', $actual, $cant);";
}

$res = $RBD->query($sql);

$rows = array();

while($row = mysqli_fetch_assoc($res)){
	$arr = array();
	foreach($row AS $k => $v){
		$arr[$k] = $v;
	}
	$rows[] = $arr;
}

$arrTable = array(
	"mainHead"		=>	"Lista de Sucursales",
	"headers"		=>	array("Id", "Nombre", "Versi&oacute;n", "Estado", "Ciudad", "Direcci&oacute;n", "Tel&eacute;fono"),
	"rows"			=>	$rows,
	"indexes"		=>	array("idCorresponsal", "nombreCorresponsal", "nombreVersion", "nombreEntidad", "nombreMunicipio", "lblDireccion", "telefono1"),
	"formats"		=>	array("","","","","","",""),
	"widths"		=>	array(40, 100, 80, 100, 100, 150, 100),
	"filtersHead"	=>	array("Estado", utf8_encode("Versi&oacute;n")),
	"filtersValue"	=>	array(utf8_encode($lblEstado), utf8_encode($lblVersion))
);

if(count($rows)>0){
	include("../../../pdf/crearTblPdf.php");
	$html = $tbl;
}else{
	$html = "Estado : ".utf8_encode($lblEstado)."<br>";
	$html .= utf8_encode("Versi&oacute;n : ").$lblVersion."<br>";
	$html .= "<h2>No se encontraron Sucursales</h2>";
}
$pdf->writeHTML($html, false, false, false, false, '');
$pdf->Output();
?>