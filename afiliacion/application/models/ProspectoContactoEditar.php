
<?php
       
include ('../../../inc/config.inc.php');



$rfc = '';//'3';
$idcont = $_POST["idcont"];
$idusuario = $_POST["usuario"];
$idtipo = $_POST["tipo"];
$nombre = strtoupper ( utf8_decode($_POST["nom"]));
$paterno = strtoupper ( utf8_decode($_POST["pat"]));
$materno = strtoupper ( utf8_decode($_POST["mat"]));
$telef = $_POST["tel"];
$telefono = preg_replace("/[^0-9]/","", $telef);
$extencion = $_POST["ext"];
$celu = $_POST["cel"];
$celular = preg_replace("/[^0-9]/","", $celu);
$email = $_POST["mail"];
$descripcion = utf8_decode($_POST["desc"]);
//""
$sQuery = "call afiliacion.SP_CONTACTO_GUARDAR_CAMBIOS('$rfc',$idcont,$idusuario,$idtipo,'$nombre','$paterno','$materno','$telefono','$extencion','$celular','$email','$descripcion');";

$resultcont = $WBD->query($sQuery);
$DATS  = mysqli_fetch_array($resultcont);
               
               
$rowcount     =    $DATS['cuenta'];

  $count = json_encode(array(
              "rows" => "$rowcount",
       ));   



echo $count;

//mysqli_close($conn);
?>
 
