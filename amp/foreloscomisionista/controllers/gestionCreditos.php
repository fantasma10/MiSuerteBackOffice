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
class configuracionComisionistas{
    private $setdfecha1;
    private $setdfecha2;
    private $setnstatusCredito;
    function setdfecha1($setdfecha1){
        $this->setdfecha1=$setdfecha1;
    }   
    function setdfecha2($setdfecha2){
        $this->setdfecha2=$setdfecha2;
    }   
    function setnstatusCredito($setnstatusCredito){
        $this->setnstatusCredito=$setnstatusCredito;
    }  
    function forelosComisionistas(){
    include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php");
    $ArrayRetorno=[];
        // $param = array
        //         (    
        //             array(
        //             'name'  => 'CkdFechaInicio',
        //             'type'  => 's',
        //             'value' => $this->setdfecha1),
        //             array(
        //             'name'  => 'CkdFechaFinal',
        //             'type'  => 's',
        //             'value' => $this->setdfecha2),
        //             array(
        //             'name'  => 'CknIdEstatus',
        //             'type'  => 's',
        //             'value' => $this->setnstatusCredito)    
        //         );
        //         $oRAMP->setSDatabase('data_AquiMisPagos');
        //         $oRAMP->setSStoredProcedure('sp_select_gestion_creditos'); // -> Todo el SP hace referencia a redefectiva y data_acceso.
        //         $oRAMP->setParams($param);                
        //         $result2 = $oRAMP->execute();
        //         $data = $oRAMP->fetchAll();  print_r($data); die();
        //         $oRAMP->closeStmt();
        //         $ArrayRetorno['data'] = $data;

                // *** WS ***
                    $arrayParametros= array(        
                        'FechaInicio' => $this->setdfecha1,
                        'FechaFin' => $this->setdfecha2,
                        'IdEstatus' => $this->setnstatusCredito
                    );    

                    $respuesta =(array) $client->ObtenerGestionCreditosPorRango($arrayParametros);  //print_r($respuesta); die();
                    $respuestaListado =(array) $respuesta['ObtenerGestionCreditosPorRangoResult']->Model->anyType;  //print_r($respuestaListado);

                    if( isset($respuestaListado['enc_value']) ){
                        $fecha_solicitud = substr($respuestaListado['enc_value']->FechaSolicitud,0,10);
                        $respuestaListado['enc_value']->FechaSolicitud = $fecha_solicitud;
                        $ArrayRetorno['data'][]=(array)$respuestaListado['enc_value'];
                    }else{
                        foreach ( ($respuestaListado) as $key) {
                            if( $key->enc_value->FechaSolicitud ){
                                $fecha_solicitud = substr($key->enc_value->FechaSolicitud,0,10);
                                $key->enc_value->FechaSolicitud = $fecha_solicitud;
                            }
                            $ArrayRetorno['data'][]=(array) $key->enc_value;   
                        }
                    }

                // **********
        return $ArrayRetorno;        
    }  
}
$obj = new configuracionComisionistas();
$obj->setdfecha1($_POST['fecha1']);
$obj->setdfecha2($_POST['fecha2']);
$obj->setnstatusCredito($_POST['statusCredito']);
$result=$obj->forelosComisionistas();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));

?>