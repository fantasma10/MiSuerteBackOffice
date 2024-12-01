<?php
include ('../../../inc/config.inc.php');
$rfc = $_POST['rfc'];
$sQueryforelo = "call afiliacion.SP_REVISAR_FORELO('$rfc');";
$resultForelo = $WBD->query($sQueryforelo);
$forelo  = mysqli_fetch_array($resultForelo);


$referencia     = $forelo['sReferencia'];
$inscripcion    = $forelo['nInscripcionCliente'];
$depositado     = $forelo['dDepositado'];
$fecha          = $forelo['dUltFechaDeposito'];
$pendiente      = $forelo['pendiente'];
                  
     $datos = array(
        "referencia" =>$referencia,
        "iniscripcion" =>$inscripcion,
        "depositado" =>$depositado,
        "fecha" =>$fecha,
        "pendiente" =>$pendiente,
            );

$records = json_encode($datos);

echo $records;


?>