<?php
/*
********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .CSV DESCARGABLE **********
*/
include("../../config.inc.php");


$sql = $_SESSION['sqlcorresponsales'];
$nombre = "corresponsales.csv";

$cabeceras = array("IdCorresponsal","NombreCorresponsal");
if(isset($_SESSION['sqlcorresponsales']) && $_SESSION['sqlcorresponsales'] != ""){
	include("../CrearArchivoCSV.php");
}
?>