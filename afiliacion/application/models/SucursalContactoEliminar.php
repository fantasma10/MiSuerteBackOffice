
<?php
       
include ('../../../inc/config.inc.php');
$idcont = $_POST["idcont"];
$idsuc= $_POST["idsuc"];
//""
$sQuery = "call afiliacion.SP_CONTACTO_SUCURSAL_ELIMINAR('$idsuc','$idcont');";
$resultcont = $WBD->query($sQuery);

$DATS  = mysqli_fetch_array($resultcont);
               
               
$rowcount     =    $DATS['cuenta'];

  $count = json_encode(array(
              "rows" => "$rowcount",
       ));   



echo $count;

//mysqli_close($conn);
?>
 
