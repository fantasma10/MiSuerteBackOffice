
<?php
        
include ('../../../inc/config.inc.php');



$ruta = $_POST['ruta'];



	$sQuery = "CALL afiliacion.SP_SELECT_RUTA_MONTOS('$ruta');";
$resulruta = $WBD->query( $sQuery );
$resp  = mysqli_fetch_array($resulruta); 
     
    $perComCor = $resp['perComCorresponsal']; 
    $impComCor = $resp['impComCorresponsal']; 
    $perComCli = $resp['perComCliente']; 
    $impComCli = $resp['impComCliente']; 
    $perCosto = $resp['perCostoRuta']; 
    $impCosto = $resp['impCostoRuta']; 
    $impMax = $resp['impMaxRuta']; 
    $impMin = $resp['impMinRuta']; 
 



$datos = array(

    "perComCor"=>$perComCor,
    "impComCor"=>$impComCor,
    "perComCli"=>$perComCli,
    "impComCli"=>$impComCli,
    "perCosto"=>$perCosto,
    "impCosto"=>$impCosto,
    "impMax"=>$impMax,
    "impMin"=>$impMin
);


echo json_encode($datos);

     ?>
                    

