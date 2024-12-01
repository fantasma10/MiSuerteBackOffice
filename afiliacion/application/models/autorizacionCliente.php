
<?php
        
include ('../../../inc/config.inc.php');


$rfc = $_POST['rfc'];



$query = "CALL afiliacion.sp_update_forelo_prospecto('$rfc');";

//echo $query;

$result = $WBD->query($query);
$DAT = mysqli_fetch_array($result);

$codigo = $DAT['cod'];

//var_dump($DAT);

IF($codigo == 0){
   
       $sQuery = "CALL afiliacion.SP_CREAR_CLIENTE('$rfc');";
        $resultado = $WBD->query( $sQuery );
        $DATA= mysqli_fetch_array($resultado);
        $datos = array(

             "cod" => $DATA['code'],
             "msg" => $DATA['msg']
         );
        echo json_encode($datos);
}else{
    
    $datix = array(

             "cod" => $DAT['cod'],
             "msg" => $DAT['msg']
         );
        echo json_encode($datix);
    
    
    
}






?>
 