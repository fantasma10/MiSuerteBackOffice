
<?php
        
include ('../../../inc/config.inc.php');


$rfc = $_POST['rfc'];
$producto = $_POST['producto'];
$ruta = $_POST['ruta'];



	$sQuery = "CALL afiliacion.SP_SELECT_PERMISOS_DUPLICADOS_PROSPECTOS('$rfc','$producto','$ruta');";
$resultperm = $WBD->query( $sQuery );
$resp  = mysqli_fetch_array($resultperm); 
     
    $cuenta = $resp['cuenta']; 
 
     
     

$datos = array(

    "cuenta"=>$cuenta
);


echo json_encode($datos);

     ?>
                    

