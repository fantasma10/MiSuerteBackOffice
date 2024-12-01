<?php
/*
	********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .CSV DESCARGABLE **********
*/
include("../../config.inc.php");
include("../../session.ajax.inc.php");

/* recibimos los parametros por post, vienen en formato como si se hubieran pasado por la url proveedor=1&familia=2&... */
$lblEstado			= (!empty($_POST['lblEstado']))?$_POST["lblEstado"]:"";
$lblVersion 		= (!empty($_POST['lblVersion']))?$_POST["lblVersion"]:"";

$todos  			= (isset($_POST['todos']))?$_POST['todos']:0;
$estado  			= (isset($_POST['estado']))?$_POST['estado']:0;

$version 			= (isset($_POST['version']))?$_POST['version']:0;
$numDias			= (!empty($_POST['numDiasExcel']))? $_POST['numDiasExcel'] : -1;
$numOperaciones		= (!empty($_POST['numOpSucursalExcel']))? $_POST['numOpSucursalExcel'] : -1;
$tipoBusqueda		= (isset($_POST['tipoBusquedaExcel']))? $_POST['tipoBusquedaExcel'] : '';
$cant    			= (isset($_POST['cant']))?$_POST["cant"]:20;
$actual  			= (!empty($_POST['actual']))?$_POST["actual"]:0;

if ( !$todos ) {
	if($actual > 0){
		$actual = $actual * $cant - $cant;
	}
} else {
	$actual = 0;
}

if ( $cant >= 100 ) {
	$sql = "CALL `redefectiva`.`SP_BUSCA_SUCURSALES`($estado, $version, $numDias, $numOperaciones, '$tipoBusqueda', $actual, 100);";
} else {
	$sql = "CALL `redefectiva`.`SP_BUSCA_SUCURSALES`($estado, $version, $numDias, $numOperaciones, '$tipoBusqueda', $actual, $cant);";
}
//var_dump($sql);
$res = $RBD->SP($sql);

$rows = array();

while($row = mysqli_fetch_assoc($res)){
	$arr = array();
	foreach($row AS $k => $v){
		$arr[$k] = $v;
	}
	$rows[] = $arr;
}

/* arreglo con configuración e información para la tabla html exportada a excel que se generará con el archivo exportExcel.php */
$arrTable = array(
	"mainHead"		=> "Sucursales",
	"headers"		=>	array("Id", "Nombre", "Versi&oacute;n", "Estado", "Ciudad", "Direcci&oacute;n", "Tel&eacute;fono"),
	"rows"			=>	$rows,
	"indexes"		=>	array("idCorresponsal", "nombreCorresponsal", "nombreVersion", "nombreEntidad", "nombreMunicipio", "lblDireccion", "telefono1"),
	"filtersHead"	=>	array("Estado", utf8_encode("Versi&oacute;n")),
	"filtersValue"	=>	array($lblEstado, $lblVersion),
	"formats"		=>	array("","","","","","",""),
);

/* incluimos el archivo que genera la tabla html y lo exporta a excel */
include("../../../excel/exportExcelSucursales.php");

function money($float){
	if(is_numeric($float)){
		return "\$ ".number_format($float,2);
	}else{
		return $float;
	}
}

?>