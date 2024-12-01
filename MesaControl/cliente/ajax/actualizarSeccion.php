<?php
 
if ($_POST["config"]) {
     include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
}    
    
$idCliente = $_POST["idCliente"];
$estatus = $_POST["estatusCliente"];

$secciones = explode("," , $_POST['secciones']); 
$secciones[$_POST["numSeccion"]-1] = "1";

// Si el cliente ya esta activo no crear/actualizar secciones
if ($estatus != 0) {
    $sQuerySeccion = "CALL redefectiva.sp_update_cliente_secciones(
        $idCliente, 
        $secciones[0], 
        $secciones[1], 
        $secciones[2], 
        $secciones[3], 
        $secciones[4], 
        $secciones[5], 
        $secciones[6], 
        $secciones[7]
    );";
    
    $resSeccion = $WBD->query($sQuerySeccion);
}
  
?>
 
