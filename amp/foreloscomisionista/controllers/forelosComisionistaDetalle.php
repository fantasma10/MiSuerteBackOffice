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
class forelosComisionistaDetalle{
    private $setnIdUsuario;
    function setnIdUsuario($setnIdUsuario){
        $this->setnIdUsuario=$setnIdUsuario;
    }    
    function buscaComDetalle(){
	include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php");
                $param = array
                (    
	                 array(
	                'name'	=> 'CknIdUsuario',
	                'type'	=> 's',
	                'value'	=> $this->setnIdUsuario)    
                );

                // $oRAMP->setSDatabase('data_AquiMisPagos');
                //$oRAMP->setSStoredProcedure('sp_select_consultarComisionistaDetalle');
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_consultarComisionista_Detalle'); // ok

                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();

                $arrayParametrosCorresponsal= array(        
                    'IdCorresponsal' => $data[0]['nIdCorresponsalRE']
                ); 
                $respuesta = '';
                $respuesta =(array) $client->ObtenerCuentaForelo($arrayParametrosCorresponsal);
                $numCuenta = $respuesta['ObtenerCuentaForeloResult']->Model->anyType->enc_value->NumCuenta;
                $SaldoCuenta = $respuesta['ObtenerCuentaForeloResult']->Model->anyType->enc_value->SaldoCuenta;

                $arrayParametrosCliente= array(        
                    'IdCorresponsal' => $data[0]['nIdCorresponsalRE'],
                    'IdCadena' => 169,
                    'IdSubCadena' => $data[0]['nIdSubCadenaRE']
                ); 
                $respuesta = '';
                $respuesta =(array) $client->ObtenerCortePorId($arrayParametrosCliente);
                
                $arrayParametrosComisionista= array(        
                    'IdCadena' => 169,
                    'IdSubCadena' => $data[0]['nIdSubCadenaRE'],
                    'Idcorresponsal' => $data[0]['nIdCorresponsalRE']
                );
                $respuesta2 =(array) $client->ObtenerComisionista($arrayParametrosComisionista);

                $vsNumeroTiendas = $respuesta2['ObtenerComisionistaResult']->Model->anyType->enc_value->NumeroTiendas;
                $vDepositoComisiones = $respuesta2['ObtenerComisionistaResult']->Model->anyType->enc_value->DepositoComisiones;
                $vCLABE = $respuesta2['ObtenerComisionistaResult']->Model->anyType->enc_value->CLABE;
                $idCliente = $respuesta['ObtenerCortePorIdResult']->Model->anyType->enc_value->IdCliente;

                $sNombre = $data[0]['sNombre'];
                $sApellidoPaterno = $data[0]['sApellidoPaterno'];
                $sApellidoMaterno = $data[0]['sApellidoMaterno'];

                $razonSocial = '';
                if(strlen($data[0]['sRFC']) == 13 ){
                    $razonSocial = $sNombre.' '.$sApellidoPaterno.' '.$sApellidoMaterno;
                }else{
                    $razonSocial = $respuesta['ObtenerCortePorIdResult']->Model->anyType->enc_value->RazonSocial;
                }

                $data[0]['numCuenta']=$numCuenta;
                $data[0]['saldoCuenta']=$SaldoCuenta;
                $data[0]['sNumeroTiendas']=$vsNumeroTiendas;
                $data[0]['DepositoComisiones']=$vDepositoComisiones;
                $data[0]['idCliente']=$idCliente;
                $data[0]['RazonSocial']=$razonSocial;
                $data[0]['CLABE']=$vCLABE;

                $ArrayRetorno['data'] = $data;

        return $ArrayRetorno;
    }  
}

$obj = new forelosComisionistaDetalle();
$obj->setnIdUsuario($_POST['nIdUsuario']);
$result=$obj->buscaComDetalle();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));

?>