<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

//VARIABLES NECESARIAS PARA LA CREACION DEL ARCHIVO .CSV o PDF
$_SESSION['sqlsucursales'] = "";
$_SESSION['sqltodassucursales'] = "";

$estado				= (isset($_POST['estado']))? $_POST['estado'] : 0;
$version			= (isset($_POST['version']))? $_POST['version'] : 0;
$numDias			= (!empty($_POST['numDias']))? $_POST['numDias'] : -1;
$numOperaciones		= (isset($_POST['numOperaciones']))? $_POST['numOperaciones'] : -1;
$tipoBusqueda		= (isset($_POST['tipoBusqueda']))? $_POST['tipoBusqueda'] : '';
$cant				= (isset($_POST['cant']))?$_POST["cant"]:20;
$start				= (!empty($_POST['actual']))?$_POST["actual"]:0;
$start				= ($start != "undefined")? $start : 0;

if ($start > 0) {
    $start = $start * $cant - $cant;
}

if ( $numOperaciones == "" ) {
	$numOperaciones = -1;
}

$sql = "CALL `redefectiva`.`SP_BUSCA_SUCURSALES`($estado, $version, $numDias, $numOperaciones, '$tipoBusqueda', $start, $cant);";
$res = $RBD->SP($sql);

$sqlcount = "SELECT FOUND_ROWS();";

$funcion = "BuscaSucursales";
include("../actualpaginacion.php");

if (mysqli_num_rows($res) > 0) {
    $d = "0%%<table id='ordertabla' border='0' cellspacing='0' cellpadding='0' class='tablesorter tasktable'><thead><tr><th>Id</th><th>Nombre</th><th>Versi&oacute;n</th><th>Estado</th><th>Ciudad</th><th>Direcci&oacute;n</th><th>Tel&eacute;fono</th></tr></thead><tbody>";
    while ($row = mysqli_fetch_array($res)) {
        $id = $row["idCorresponsal"];
        $nombre = $row["nombreCorresponsal"];
        $version = $row["nombreVersion"];
        $ident = $row["nombreEntidad"];
        $ciudad = $row["nombreMunicipio"];

        $row["numeroExtDireccion"] = preg_replace("/#/", "", $row["numeroExtDireccion"]);
        $row["numeroExtDireccion"] = "#".$row["numeroExtDireccion"];

        $direccion = $row["calleDireccion"]." ".$row["numeroExtDireccion"].", Col. ".$row["nombreColonia"]." CP. ".$row["cpDireccion"];
        $telefono = $row["telefono1"];

        $d .= "<tr><td>$id</td><td>$nombre</td><td>$version</td><td>$ident</td><td>$ciudad</td><td>$direccion</td><td>$telefono</td></tr>";
    }
    $d .= "</tbody></table>";
    echo utf8_encode($d);
} else {
    echo "500%%<span style='color:#f00;'>Lo sentimos pero no se encontraron Sucursales.</span>";
}

//CODIGO PARA LA PAGINACION DE LOS RESULTADOS
echo "<br />";
echo "<table align='center'><tr><td>";

//NECESARIO INCLUIR PARA LA PAGINACION
include("../paginanavegacion.php");
echo "</td></tr></table>";
?>
