
<?php
       
include ('../../../inc/config.inc.php');
$idcont = $_POST["idcont"];
//""

$sQuery = "call afiliacion.SP_CONTACTO_ELIMINAR('$idcont');";
$resultcont = $WBD->query($sQuery);

$DATS  = mysqli_fetch_array($resultcont);
               
  //$WBD->query             
$rowcount     =    $DATS['cuenta'];

  $count = json_encode(array(
              "rows" => "$rowcount",
       ));   



echo $count;

//mysqli_close($conn);
?>
 
