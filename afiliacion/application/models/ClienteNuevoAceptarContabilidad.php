
<?php
       
include ('../../../inc/config.inc.php');




$idcte = $_POST["idcte"];

//""
$sQuery = "call afiliacion.SP_CLIENTE_NUEVO_ACEPTADO_CONTABILIDAD('$idcte');";

$resultcont = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcont);
               
               
$rowcount     =    $DATS['cuenta'];

  $count = json_encode(array(
              "rows" => "$rowcount",
       ));   



echo $count;

//mysqli_close($conn);
?>
 
