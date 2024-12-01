<?php
include ('../../../inc/config.inc.php');

$idpermiso = (!empty($_POST['idperm']))? $_POST['idperm'] : 0;
$rfc = $_POST['rfc'];
$cadena = (!empty($_POST['cadena']))? $_POST['cadena'] :1;
$subcadena = $_POST['subcadena'];
$version = $_POST['version'];
$ruta = $_POST['ruta'];
$producto = $_POST['producto'];
$prioridad = $_POST['prioridad'];
$vigenciaIni = date('Y-m-d H:i:s');// ahora
$vigenciaFin = date('Y-m-d H:i:s');//, strtotime('+20 years')); // ahora mas 20 años
$percte = $_POST['percte'];
$impcte = $_POST['impcte'];
$pergrp = $_POST['pergrp'];
$impgrp = $_POST['impgrp'];
$perusr = $_POST['perusr'];
$impusr = $_POST['impusr'];
$peresp = $_POST['peresp'];
$impesp = $_POST['impesp'];
$percosto = $_POST['percosto'];
$impcosto = $_POST['impcosto'];
$impmax = $_POST['impmax'];
$impmin = $_POST['impmin'];
$estatus = $_POST['estatus'];
$empleado = $_POST['empleado'];



$sQuery = "call afiliacion.SP_INSERT_UPDATE_PERMISOS_PROSPECTO('$idpermiso','$rfc','$cadena','$subcadena','$version','$ruta','$producto','$prioridad','$vigenciaIni','$vigenciaFin','$percte','$impcte','$pergrp','$impgrp','$perusr','$impusr','$peresp','$impesp','$percosto','$impcosto','$impmax','$impmin','$estatus','$empleado');";

//echo $sQuery;
$result = $WBD->query($sQuery);
$resp  = mysqli_fetch_array($result);


$codigo     = $resp['cod'];
$mensaje    = $resp['msg'];

                  
     $datos = array(
        "codigo" =>$codigo,
        "mensaje" =>$mensaje
       
            );

echo  json_encode($datos);




?>