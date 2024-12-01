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
    private $setCkbCredito; 
    private $setCksComisionista;
    function setCkbCredito($setCkbCredito){
        $this->setCkbCredito=$setCkbCredito;
    }   
    function setCksComisionista($setCksComisionista){
        $this->setCksComisionista=$setCksComisionista;
    }

    function forelosComisionistas(){    
    include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php");
        $param = array
                (                     
                    array(
                    'name'  => 'CksComisionista',
                    'type'  => 's',
                    'value' => $this->setCksComisionista),
                    array(
                    'name'  => 'CkbCredito',
                    'type'  => 's',
                    'value' => $this->setCkbCredito)

                );  
                // //$oRAMP->setSStoredProcedure('sp_select_forelosComisionistas'); // se actualizo por otro sp
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_forelos_Comisionistas');    

                $oRAMP->setParams($param);                
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();     
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data; 

                for($i=0; $i<count($data); $i++)
                {
                    $arrayParametros= array(      
                        'IdCadena' => 169,
                        'IdSubCadena' => $data[$i]['nIdSubCadenaRE'],
                        'Idcorresponsal' => $data[$i]['nIdCorresponsalRE']
                    );

                    $respuesta =(array) $client->ObtenerComisionista($arrayParametros);

                    $vnombreCorresponsal = $respuesta['ObtenerComisionistaResult']->Model->anyType->enc_value->NombreCorresponsal;
                    $vsaldoCuenta = $respuesta['ObtenerComisionistaResult']->Model->anyType->enc_value->SaldoCuenta;
                    $vsNombre = $respuesta['ObtenerComisionistaResult']->Model->anyType->enc_value->RazonSocial;
                    $vidTipoLiqComision = $respuesta['ObtenerComisionistaResult']->Model->anyType->enc_value->IdTipoLiqComision;
                    $vCLABE = $respuesta['ObtenerComisionistaResult']->Model->anyType->enc_value->CLABE; 
                    
                    $ArrayRetorno['data'][$i]['nombreCorresponsal'] = $vnombreCorresponsal;
                    $ArrayRetorno['data'][$i]['saldoCuenta'] = $vsaldoCuenta;
                    $ArrayRetorno['data'][$i]['sNombre'] = $vsNombre;
                    $ArrayRetorno['data'][$i]['idTipoLiqComision'] = $vidTipoLiqComision;
                    $ArrayRetorno['data'][$i]['CLABE'] = $vCLABE;
                }

        return $ArrayRetorno;        
    }  
}
$obj = new configuracionComisionistas();
$obj->setCksComisionista($_POST['CksComisionista']);
$obj->setCkbCredito($_POST['CkbCredito']);
$result=$obj->forelosComisionistas();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));

?>