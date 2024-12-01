<?php
function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}
class gestionCreditosDetalle{
    private $setidsMovimiento;
    function setidsMovimiento($setidsMovimiento){
        $this->setidsMovimiento=$setidsMovimiento;
    }    
    function gestionDetalle(){
	include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");  
    include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php"); 
    $ArrayRetorno=[]; 
    $respuestaListado=[];         
            // $param = array
            // (    
            //      array(
            //     'name'	=> 'CksBusca',
            //     'type'	=> 's',
            //     'value'	=> $this->setidsMovimiento)    
            // );
            // $oRAMP->setSDatabase('data_AquiMisPagos');
            // $oRAMP->setSStoredProcedure('sp_select_gestion_creditos_detalle'); // Este sp filtra por numero de movimiento que depende de redefectiva principalmente, no de data_aquimispagos
            // // $oRAMP->setSStoredProcedure('sp_select_gestion_creditos_detalle');
            // $oRAMP->setParams($param);
            // $result2 = $oRAMP->execute();
            // $data = $oRAMP->fetchAll();                
            // $oRAMP->closeStmt();
            // $ArrayRetorno['data'] = $data; print_r($ArrayRetorno); die();

            // *** WS ***
                $arrayParametros= array(        
                    'IdMovimiento' => $this->setidsMovimiento
                );  
                $respuesta =(array) $client->ObtenerGestionCreditosDetallePorIdMov($arrayParametros);  //print_r($respuesta); die();
                $respuestaListado =(array) $respuesta['ObtenerGestionCreditosDetallePorIdMovResult']->Model->anyType;  //print_r($respuestaListado); //die();
                
                if( isset($respuestaListado['enc_value']) ){
                    $ArrayRetorno['data']=$respuestaListado['enc_value'];
                }else{
                    $ArrayRetorno['data']=(array)$respuestaListado[0]->enc_value;
                }
                
                
            // **********
            //print_r($ArrayRetorno); die();
        return $ArrayRetorno;   
    }  
}

$obj = new gestionCreditosDetalle();
$obj->setidsMovimiento($_POST['idsMovimiento']);
$result=$obj->gestionDetalle();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));

?>