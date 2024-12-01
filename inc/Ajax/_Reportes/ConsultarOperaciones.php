<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

//VARIABLES NECESARIAS PARA LA CREACION DEL ARCHIVO .CSV
$_SESSION['sqloperaciones'] = "";
$_SESSION['sqltodasoperaciones'] = "";

$idCad			= (isset($_POST['idcadena']) && $_POST['idcadena'] != "")?$_POST['idcadena']:-1;
$idSubCad		= (isset($_POST['idsubcadena']) && $_POST['idsubcadena'] != "")?$_POST['idsubcadena']:-1;
$idCorresponsal	= (isset($_POST['idcorresponsal']) && $_POST['idcorresponsal'] != "")?$_POST['idcorresponsal']:-1;
$familia		= (!empty($_POST['familia']))?$_POST['familia']:-1;
$subfamilia		= (!empty($_POST['subfamilia']))?$_POST['subfamilia']:-1;
$proveedor		= (!empty($_POST['proveedor']))?$_POST['proveedor']:-1;
$emisor			= (!empty($_POST['emisor']))?$_POST['emisor']:-1;
$fecha1			= (!empty($_POST['fecha1']))?$_POST['fecha1']:date("Y-m-d");
$fecha2			= (!empty($_POST['fecha2']))?$_POST['fecha2']:date("Y-m-d");

$cant		= (!empty($_POST["cant"]))? $_POST["cant"] : 20;
$actual		= (!empty($_POST["actual"]))? $_POST["actual"] : 0;
if($actual == "undefined"){
	$actual = 0;
}
else{
	$actual = $actual * $cant - $cant;
}

$sql = "CALL redefectiva.SP_BUSCA_OPERACIONES_FILTROS($idCad, $idSubCad, $idCorresponsal, $familia, $subfamilia, $proveedor, $emisor, '$fecha1', '$fecha2', $actual, $cant);";
$res = $RBD->query($sql);
//echo "<pre>"; echo var_dump($RBD->error()); echo "</pre>";
$funcion = "BuscarOperaciones";
//$sqlcount = "SELECT COUNT(`idsOperacion`) FROM `redefectiva`.`ops_operacion` WHERE `idEstatusOperacion`= 0 $AND ORDER BY `idsOperacion` DESC;";
$sqlcount = "SELECT FOUND_ROWS();";

//NECESARIO INCLUIR PARA LA PAGINACION
include("../actualpaginacion.php");	
	//QUERY PARA LAS OPERACIONES				
	if(mysqli_num_rows($res) > 0){
	$d = "<table id='ordertabla' border='0' cellspacing='0' cellpadding='0' class='tablesorter tasktable'><thead><tr><th>Folio</th><th>No. Cta</th><th>Referencia</th><th>Fec. Solic.</th><th>Fec. Aplic.</th><th>Operador</th><th>Autorizaci&oacute;n</th><th>Estatus</th><th>Proveedor</th><th>Producto</th><th>Importe</th></tr></thead><tbody>";
		while($r = mysqli_fetch_array($res)){
		$d.="<tr><td>$r[0]</td><td>$r[1]</td><td>$r[2]</td><td>$r[3]</td><td>$r[4]</td><td>$r[5]</td><td>$r[6]</td><td>$r[7]</td><td>$r[8]</td><td>$r[9]</td><td>\$".number_format($r[10],2)."</td></tr>";
		}
		$d.="</tbody></table>";
		echo utf8_encode($d);
	}else{
		echo "<span style='color:#f00;'>Lo sentimos pero no se encontraron operaciones...</span>";
	}

//CODIGO PARA LA PAGINACION DE LOS RESULTADOS
echo "<table align='center'><tr><td>";
//NECESARIO INCLUIR PARA LA PAGINACION
include("../paginanavegacion.php");
echo "</td></tr></table>";
			
?>