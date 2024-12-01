<?php

class consutar_clasificacion_producto{

    function clasificacion_producto(){
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
       $oRAMP->setSStoredProcedure('sp_select_clasificacion_producto');
       $result2 = $oRAMP->execute();
       $data = $oRAMP->fetchAll();
       $oRAMP->closeStmt();
       return $data;   
    }
  
}

$obj = new consutar_clasificacion_producto();

$result=$obj->clasificacion_producto();


echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));
//echo json_encode($result);
//var_dump($result);
?>