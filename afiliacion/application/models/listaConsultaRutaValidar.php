
<?php
        
include ('../../../inc/config.inc.php');



$ruta = $_POST['ruta'];
$perCorr = $_POST['perCor'];
$impCorr = $_POST['impCor'];



	$sQuery = "CALL afiliacion.SP_SELECT_VALIDA_PARAMETROS('$ruta','$perCorr','$impCorr');";
$resulruta = $WBD->query( $sQuery );
$resp  = mysqli_fetch_array($resulruta); 
     
    $cod = $resp['cod']; 
    $msg = $resp['msg']; 
  


$datos = array(

    "cod"=>$cod,
    "msg"=>$msg
  
);


echo json_encode($datos);

     ?>
                    

