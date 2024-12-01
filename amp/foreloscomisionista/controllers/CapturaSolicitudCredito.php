<?php
$PATHRAIZ   =  $_SERVER['HTTP_HOST'];
$BASE_PATH  = $PATHRAIZ;    
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
class CapturaSolicitudCredito{
        private $setnNumeroCuenta;
        private $setnCargo;
        private $setnAbono;
        private $setsDescripcion;
        private $setnTipoMovimiento;
        private $setnIdusuarioRE;
        private $setnIdTipoCobro;
        private $setdFecCobroE;
        private $setnIdSolicitudCredito;        

        function setnNumeroCuenta($setnNumeroCuenta){
            $this->setnNumeroCuenta=$setnNumeroCuenta;
        }
        function setnCargo($setnCargo){
            $this->setnCargo=$setnCargo;
        }
        function setnAbono($setnAbono){
            $this->setnAbono=$setnAbono;
        }
        function setsDescripcion($setsDescripcion){
            $this->setsDescripcion=$setsDescripcion;
        }
        function setnTipoMovimiento($setnTipoMovimiento){
            $this->setnTipoMovimiento=$setnTipoMovimiento;
        }
        function setnIdusuarioRE($setnIdusuarioRE){
            $this->setnIdusuarioRE=$setnIdusuarioRE;
        }
        function setnIdTipoCobro($setnIdTipoCobro){
            $this->setnIdTipoCobro=$setnIdTipoCobro;
        }
        function setdFecCobroE($setdFecCobroE){
            $this->setdFecCobroE=$setdFecCobroE;
        }
        function setnIdSolicitudCredito($setnIdSolicitudCredito){
            $this->setnIdSolicitudCredito=$setnIdSolicitudCredito;
        }

    function SolicitudCredito(){
        include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
        include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php");
                $param = array
                ( 
                    array(
                    'name'  => 'CksetnNumeroCuenta',
                    'type'  => 'i',
                    'value' => $this->setnNumeroCuenta),
                    array(
                    'name'  => 'CksetnCargo',
                    'type'  => 'd',
                    'value' => $this->setnCargo),
                    array(
                    'name'  => 'CksetnAbono',
                    'type'  => 'd',
                    'value' => $this->setnAbono),
                    array(
                    'name'  => 'CksetsDescripcion',
                    'type'  => 's',
                    'value' => $this->setsDescripcion),
                    array(
                    'name'  => 'CksetnTipoMovimiento',
                    'type'  => 'i',
                    'value' => $this->setnTipoMovimiento),
                    array(
                    'name'  => 'CksetnIdusuarioRE',
                    'type'  => 'i',
                    'value' => $this->setnIdusuarioRE),
                    array(
                    'name'  => 'CksetnIdTipoCobro',
                    'type'  => 'i',
                    'value' => $this->setnIdTipoCobro),
                    array(
                    'name'  => 'CksetdFecCobroE',
                    'type'  => 's',
                    'value' => $this->setdFecCobroE)
                );

                //$oRAMP->setSDatabase('data_AquiMisPagos');
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_insert_solicitud_credito'); // ok. no hay ws. el sp apunta solo a aquimispagos

                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll(); // Retorna solo valor de: nIdSolicitudCredito
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;

                $param2 = array
                ( 
                    array(
                    'name'  => 'CkdFecCobroInic',
                    'type'  => 's',
                    'value' => '0000-00-00'),
                    array(
                    'name'  => 'CkdFecCobroFinal',
                    'type'  => 's',
                    'value' => '0000-00-00'),
                    array(
                    'name'  => 'CknIdEstatusSolicitud',
                    'type'  => 'i',
                    'value' => '-1'),
                    array(
                    'name'  => 'CknIdSolicitudCredito',
                    'type'  => 'i',
                    'value' => $data[0]['nIdSolicitudCredito']),
                    array(
                    'name'  => 'CksToken',
                    'type'  => 's',
                    'value' => '')
                );
                

                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_solicitudCredito');

                $oRAMP->setParams($param2);
                $resultCorreo = $oRAMP->execute();
                $dataCoreo = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
        //print_r($dataCoreo); die();

                $arrayParametrosCuenta= array(        
                        'NumCuenta' => $dataCoreo[0]['nNumeroCuenta']
                    );  
                    $respuesta =(array) $client->ObtenerCuentaPorId($arrayParametrosCuenta);  
        
                    $resIdCadena = $respuesta['ObtenerCuentaPorIdResult']->Model->anyType->enc_value->IdCadena;
                    $resIdSubCadena = $respuesta['ObtenerCuentaPorIdResult']->Model->anyType->enc_value->IdSubCadena;
                    $resIdCorresponsal = $respuesta['ObtenerCuentaPorIdResult']->Model->anyType->enc_value->IdCorresponsal;

                // *** WS *** // 
                    $arrayParametrosCredito= array(        
                        'IdCadena' => $resIdCadena,
                        'IdSubCadena' => $resIdSubCadena,
                        'Idcorresponsal' => $resIdCorresponsal
                    );  
                    $respuesta =(array) $client->ObtenerSolicitudCredito($arrayParametrosCredito);  //print_r($respuesta); die();
                    $resSaldoCuenta = $respuesta['ObtenerSolicitudCreditoResult']->Model->anyType->enc_value->SaldoCuenta;
                    $resNumCuenta = $respuesta['ObtenerSolicitudCreditoResult']->Model->anyType->enc_value->numCuenta;
                    $resRazonSocial = $respuesta['ObtenerSolicitudCreditoResult']->Model->anyType->enc_value->RazonSocial;

                    $dataCoreo[0]['RazonSocial'] = $resRazonSocial;
                    $dataCoreo[0]['numCuenta'] = $resNumCuenta;
                    $dataCoreo[0]['saldoCuenta'] = $resSaldoCuenta;
                // **********

                // ** consultar tabla aquimispagos.map_subcadena y dat_cadena para extraer dato de nombre de cadena **
                $param3 = array
                ( 
                    array(
                    'name'  => 'ckIdSubcadena',
                    'type'  => 'i',
                    'value' => $resIdSubCadena)
                );
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_cadena_map');

                $oRAMP->setParams($param3);
                $resultMap = $oRAMP->execute();
                $dataMap = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                // **********
            
                
                $array_params = null;
                $array_params = array(
                    array(
                        'name'  => 'ckIdUsuario',
                        'type'  => 'i',
                        'value' => $dataCoreo[0]['nIdusuarioRE']
                        )
                );    
                
                $oRdb->setSDatabase('redefectiva');
                $oRdb->setSStoredProcedure('sp_select_dataAcceso_datUsuario');
                $oRdb->setParams($array_params);
                $result = $oRdb->execute();
	    	    $dataRec = $oRdb->fetchAll();

            //print_r($dataRec); die();

                $nIdSolicitudCredito = $dataCoreo[0]['nIdSolicitudCredito'];
                $sRazonSocial = str_replace(' ','_', $dataCoreo[0]['RazonSocial']);
                $sNombreCadena = str_replace(' ','_', $dataMap[0]['NombreCadena']);
                $saldoCuenta = str_replace('.','_', $dataCoreo[0]['saldoCuenta']);
                $nAbono = str_replace('.','_', $dataCoreo[0]['nAbono']);
                $sToken = str_replace(' ','_', $dataCoreo[0]['sToken']);
                $sNombreusuarioRE = str_replace(' ','_', $dataRec[0]['nombre']);
                //include_once($_SERVER['DOCUMENT_ROOT']."/amp/foreloscomisionista/views/correoAutorizacion.php");

                //$oRAMP->setSDatabase('data_AquiMisPagos');
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_gestion_creditoLimitadoAutorizantes');   // ok. No requiere WS

                $param = array();
                $oRAMP->setParams($param);      
                $result2 = $oRAMP->execute();
                $usuariosAutorizantes = ($oRAMP->fetchAll());
                $oRAMP->closeStmt();
                foreach ( ($usuariosAutorizantes) as $key) {
                    $nIdTipoCreditoNoticacion = $key['nIdTipoCreditoNoticacion'];
                    $sCorreo = $key['sCorreo'];
                    $nTelefono = $key['nTelefono'];
                    //$URL='http://10.10.1.213:8089/index.php/sistema/pruebaDescargaArchivo';
                    $URL='http://10.10.1.54:8081/index.php/sistema/pruebaDescargaArchivo'; // --> ip de mi equipo
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    //curl_setopt($ch, CURLOPT_URL, $URL.'?autorizacion=ASDASDASDSASDADAS&cancelacion=aldoNoMeCreee');
                    curl_setopt($ch, CURLOPT_URL, $URL.'?nIdSolicitudCredito='.$nIdSolicitudCredito.'&sRazonSocial='.$sRazonSocial.'&sNombreCadena='.$sNombreCadena.'&saldoCuenta='.$saldoCuenta.'&nAbono='.$nAbono.'&sToken='.$sToken.'&sNombreusuarioRE='.$sNombreusuarioRE.'&nIdTipoCreditoNoticacion='.$nIdTipoCreditoNoticacion.'&sCorreo='.$sCorreo.'&nTelefono='.$nTelefono);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                    $result['resultado'] = curl_exec ($ch);
                    curl_close ($ch);
                }

        return $ArrayRetorno;
    }  
}


$obj = new CapturaSolicitudCredito();
 
    $obj->setnNumeroCuenta($_POST['nNumCuenta']);
    $tipo = $_POST['tipo'];
    $nMonto = $_POST['nMonto'];
    if($tipo == 1){
        $obj->setnCargo($nMonto);
        $obj->setnAbono(0);
    }
    else if($tipo == 2){
        $obj->setnCargo(0);
        $obj->setnAbono($nMonto);
    }
    $obj->setsDescripcion($_POST['sDescripcion']);
    $obj->setnTipoMovimiento($_POST['nIdTipoMovimiento']);
    $obj->setnIdusuarioRE($_POST['idU']);
    $obj->setnIdTipoCobro($_POST['nIdTipoCobro']);
    $obj->setdFecCobroE($_POST['dFechaCobro']);
$result=$obj->SolicitudCredito();
echo  json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Solicitud de crédito enviada para su autorización',
    'data'      => utf8ize($result)
));

?>