
<?php
        
include ('../../../inc/config.inc.php');


$idperm = $_POST['idperm'];



	$sQuery = "CALL afiliacion.SP_DELETE_PERMISO_PROSPECTO('$idperm');";
$resultperm = $WBD->query( $sQuery );
$resp  = mysqli_fetch_array($resultperm); 
     
    $codigo = $resp['cod']; 
  $mensaje = utf8_encode($resp['msg']);
     
     

$datos = array(

    "cod"=>$codigo,
    "msg"=>$mensaje,

);


echo json_encode($datos);

     ?>
                    

