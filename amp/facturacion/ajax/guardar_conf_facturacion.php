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
class guardar_conf_facturacion{
    private $nIdFactura;
    private $nConsecutivo;
    private $sSerie;
    private $nMetodoPago;
    private $snMetodoPago;
    private $nFormaPago;
    private $snFormaPago;
    private $nCFDI;
    private $snCFDI;
    private $nProducto;
    private $snProducto;
    private $nIVA;
    private $tipoFactura;
    private $nIdFacturaServicio;
    private $nConsecutivoServicio;
    private $sSerieServicio;
    private $nMetodoPagoServicio;
    private $snMetodoPagoServicio;
    private $nFormaPagoServicio;
    private $snFormaPagoServicio;
    private $nCFDIServicio;
    private $snCFDIServicio;
    private $nProductoServicio;
    private $snProductoServicio;
    private $nIVAServicio;
    private $tipoFacturaServicio;

    function setnConsecutivo($nConsecutivo){
        $this->nConsecutivo=$nConsecutivo;
    }
    function setsSerie($sSerie){
        $this->sSerie=$sSerie;
    }
    function setnMetodoPago($nMetodoPago){
        $this->nMetodoPago=$nMetodoPago;
    }
    function setsnMetodoPago($snMetodoPago){
        $this->snMetodoPago=$snMetodoPago;
    }
    function setnFormaPago($nFormaPago){
        $this->nFormaPago=$nFormaPago;
    }
    function setsnFormaPago($snFormaPago){
        $this->snFormaPago=$snFormaPago;
    }
    function setnCFDI($nCFDI){
        $this->nCFDI=$nCFDI;
    }
    function setsnCFDI($snCFDI){
        $this->snCFDI=$snCFDI;
    }
    function setnProducto($nProducto){
        $this->nProducto=$nProducto;
    }
    function setsnProducto($snProducto){
        $this->snProducto=$snProducto;
    }
    function setnIVA($nIVA){
        $this->nIVA=$nIVA;
    }
    function setnTipoFactura($tipoFactura){
        $this->tipoFactura=$tipoFactura;
    }
    function setnIdFactura($nIdFactura){
        $this->nIdFactura=$nIdFactura;
    }
    function setnConsecutivoServicio($nConsecutivo){
        $this->nConsecutivoServicio=$nConsecutivo;
    }
    function setsSerieServicio($sSerie){
        $this->sSerieServicio=$sSerie;
    }
    function setnMetodoPagoServicio($nMetodoPagoServicio){
        $this->nMetodoPagoServicio=$nMetodoPagoServicio;
    }
    function setsnMetodoPagoServicio($snMetodoPagoServicio){
        $this->snMetodoPagoServicio=$snMetodoPagoServicio;
    }
    function setnFormaPagoServicio($nFormaPago){
        $this->nFormaPagoServicio=$nFormaPago;
    }
    function setsnFormaPagoServicio($snFormaPagoServicio){
        $this->snFormaPagoServicio=$snFormaPagoServicio;
    }
    function setnCFDIServicio($nCFDI){
        $this->nCFDIServicio=$nCFDI;
    }
    function setsnCFDIServicio($snCFDIServicio){
        $this->snCFDIServicio=$snCFDIServicio;
    }
    function setnProductoServicio($nProducto){
        $this->nProductoServicio=$nProducto;
    }
    function setsnProductoServicio($snProductoServicio){
        $this->snProductoServicio=$snProductoServicio;
    }
    function setnIVAServicio($nIVA){
        $this->nIVAServicio=$nIVA;
    }
    function setnTipoFacturaServicio($tipoFactura){
        $this->tipoFacturaServicio=$tipoFactura;
    }
    function setnIdFacturaServicio($nIdFacturaServicio){
        $this->nIdFacturaServicio=$nIdFacturaServicio;
    }




    function guardar($TAE='',$SERVICIOS=''){
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
        if($TAE != ''){
            if($this->nIdFactura != ""){
                $param = array
                (   
                    array(
                        'name'	=> 'p_nIdFactura',
                        'type'	=> 'i',
                        'value'	=> $this->nIdFactura),
                    array(
                        'name'	=> 'p_sSerie',
                        'type'	=> 's',
                        'value'	=> $this->sSerie),    
                    array(
                        'name'	=> 'p_nMetodoPago',
                        'type'	=> 'i',
                        'value'	=> $this->nMetodoPago),
                    array(
                        'name'	=> 'p_snMetodoPago',
                        'type'	=> 's',
                        'value'	=> $this->snMetodoPago),
                    array(
                        'name'	=> 'p_nFormaPago',
                        'type'	=> 'i',
                        'value'	=> $this->nFormaPago),
                    array(
                        'name'	=> 'p_snFormaPago',
                        'type'	=> 's',
                        'value'	=> $this->snFormaPago),    
                    array(
                        'name'	=> 'p_nCFDI',
                        'type'	=> 'i',
                        'value'	=> $this->nCFDI),
                    array(
                        'name'	=> 'p_snCFDI',
                        'type'	=> 's',
                        'value'	=> $this->snCFDI),    
                    array(
                        'name'	=> 'p_nProducto',
                        'type'	=> 'i',
                        'value'	=> $this->nProducto),
                    array(
                        'name'	=> 'p_snProducto',
                        'type'	=> 's',
                        'value'	=> $this->snProducto),    
                    array(
                        'name'	=> 'p_nIva',
                        'type'	=> 'i',
                        'value'	=> $this->nIVA),
                    array(
                        'name'	=> 'P_nTipoFactura',
                        'type'	=> 'i',
                        'value'	=>  $this->tipoFactura),              
                );
                $oRAMP->setSStoredProcedure('sp_update_facturacion');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data['TAE']  = $oRAMP->fetchAll()[0]['ID'];
                $oRAMP->closeStmt();
            }else{
                $param = array
                (   
                    array(
                        'name'	=> 'p_nIdFactura',
                        'type'	=> 'i',
                        'value'	=> $this->nIdFactura),
                    array(
                        'name'	=> 'p_sSerie',
                        'type'	=> 's',
                        'value'	=> $this->sSerie),    
                    array(
                        'name'	=> 'p_nMetodoPago',
                        'type'	=> 'i',
                        'value'	=> $this->nMetodoPago),
                    array(
                        'name'	=> 'p_snMetodoPago',
                        'type'	=> 's',
                        'value'	=> $this->snMetodoPago),
                    array(
                        'name'	=> 'p_nFormaPago',
                        'type'	=> 'i',
                        'value'	=> $this->nFormaPago),
                    array(
                        'name'	=> 'p_snFormaPago',
                        'type'	=> 's',
                        'value'	=> $this->snFormaPago),    
                    array(
                        'name'	=> 'p_nCFDI',
                        'type'	=> 'i',
                        'value'	=> $this->nCFDI),
                    array(
                        'name'	=> 'p_snCFDI',
                        'type'	=> 's',
                        'value'	=> $this->snCFDI),    
                    array(
                        'name'	=> 'p_nProducto',
                        'type'	=> 'i',
                        'value'	=> $this->nProducto),
                    array(
                        'name'	=> 'p_snProducto',
                        'type'	=> 's',
                        'value'	=> $this->snProducto),    
                    array(
                        'name'	=> 'p_nIva',
                        'type'	=> 'i',
                        'value'	=> $this->nIVA),
                    array(
                        'name'	=> 'P_nTipoFactura',
                        'type'	=> 'i',
                        'value'	=>  $this->tipoFactura),            
                );
                $oRAMP->setSStoredProcedure('sp_insert_facturacion');
                $oRAMP->setParams($param);
                $result = $oRAMP->execute();
                $data['TAE'] = $oRAMP->fetchAll()[0]['ID'];
                $oRAMP->closeStmt();
            }
        }
        if($SERVICIOS != ''){
            if($this->nIdFacturaServicio != ""){
                $paramServicio = array
                (   
                    array(
                        'name'	=> 'p_nIdFactura',
                        'type'	=> 'i',
                        'value'	=> $this->nIdFacturaServicio),
                    array(
                        'name'	=> 'p_sSerie',
                        'type'	=> 's',
                        'value'	=> $this->sSerieServicio),    
                    array(
                        'name'	=> 'p_nMetodoPago',
                        'type'	=> 'i',
                        'value'	=> $this->nMetodoPagoServicio),
                    array(
                        'name'	=> 'p_snMetodoPago',
                        'type'	=> 's',
                        'value'	=> $this->snMetodoPagoServicio),    
                    array(
                        'name'	=> 'p_nFormaPago',
                        'type'	=> 'i',
                        'value'	=> $this->nFormaPagoServicio),
                    array(
                        'name'	=> 'p_snFormaPago',
                        'type'	=> 's',
                        'value'	=> $this->snFormaPagoServicio),    
                    array(
                        'name'	=> 'p_nCFDI',
                        'type'	=> 'i',
                        'value'	=> $this->nCFDIServicio),
                    array(
                        'name'	=> 'p_snCFDI',
                        'type'	=> 's',
                        'value'	=> $this->snCFDIServicio),        
                    array(
                        'name'	=> 'p_nProducto',
                        'type'	=> 'i',
                        'value'	=> $this->nProductoServicio),
                    array(
                        'name'	=> 'p_snProducto',
                        'type'	=> 's',
                        'value'	=> $this->snProductoServicio),    
                    array(
                        'name'	=> 'p_nIva',
                        'type'	=> 'i',
                        'value'	=> $this->nIVAServicio),
                    array(
                        'name'	=> 'P_nTipoFactura',
                        'type'	=> 'i',
                        'value'	=>  $this->tipoFacturaServicio),         
                );
                $oRAMP->setSStoredProcedure('sp_update_facturacion');
                $oRAMP->setParams($paramServicio);
                $result2 = $oRAMP->execute();
                $data['Servicio']  = $oRAMP->fetchAll()[0]['ID'];
                $oRAMP->closeStmt();
            }else{    
                $paramServicio = array
                (
                    array(
                        'name'	=> 'p_nConsecutivo',
                        'type'	=> 'i',
                        'value'	=> $this->nConsecutivoServicio),
                    array(
                        'name'	=> 'p_sSerie',
                        'type'	=> 's',
                        'value'	=> $this->sSerieServicio),    
                    array(
                        'name'	=> 'p_nMetodoPago',
                        'type'	=> 'i',
                        'value'	=> $this->nMetodoPagoServicio),
                    array(
                        'name'	=> 'p_snMetodoPago',
                        'type'	=> 's',
                        'value'	=> $this->snMetodoPagoServicio),    
                    array(
                        'name'	=> 'p_nFormaPago',
                        'type'	=> 'i',
                        'value'	=> $this->nFormaPagoServicio),
                    array(
                        'name'	=> 'p_snFormaPago',
                        'type'	=> 's',
                        'value'	=> $this->snFormaPagoServicio),    
                    array(
                        'name'	=> 'p_nCFDI',
                        'type'	=> 'i',
                        'value'	=> $this->nCFDIServicio),
                    array(
                        'name'	=> 'p_snCFDI',
                        'type'	=> 's',
                        'value'	=> $this->snCFDIServicio),        
                    array(
                        'name'	=> 'p_nProducto',
                        'type'	=> 'i',
                        'value'	=> $this->nProductoServicio),
                    array(
                        'name'	=> 'p_snProducto',
                        'type'	=> 's',
                        'value'	=> $this->snProductoServicio),    
                    array(
                        'name'	=> 'p_nIva',
                        'type'	=> 'i',
                        'value'	=> $this->nIVAServicio),
                    array(
                        'name'	=> 'P_nTipoFactura',
                        'type'	=> 'i',
                        'value'	=>  $this->tipoFacturaServicio),         
                      
                );
                $oRAMP->setSStoredProcedure('sp_insert_facturacion');
                $oRAMP->setParams($paramServicio);
                $result2 = $oRAMP->execute();
                $data['Servicio']  = $oRAMP->fetchAll()[0]['ID'];
                $oRAMP->closeStmt();
            } 
        }    
		return $data;	
    }
  
}
$obj = new guardar_conf_facturacion();
$arrayDataPost=array();
$arrayDataPost=$_POST['data'][0];
$tae='';
$servicios='';
if(isset($arrayDataPost['txtSerie'])){
    $scmbMetodoPago = explode("(", utf8_decode($arrayDataPost['scmbMetodoPago']) );
    $scmbMetodoPago = str_replace(')',"",str_replace('(',"",$scmbMetodoPago[1]));
    $scmbFormaPago = explode("(", utf8_decode($arrayDataPost['scmbFormaPago']) );
    $scmbFormaPago = str_replace(')',"",str_replace('(',"",$scmbFormaPago[1]));
    $scmbCFDI = explode("(", utf8_decode($arrayDataPost['scmbCFDI']) );
    $scmbCFDI = str_replace(')',"",str_replace('(',"",$scmbCFDI[1]));
    $scmbProducto = explode(" ", utf8_decode($arrayDataPost['scmbProducto']) );
    $scmbProducto =  $scmbProducto[0];

    $obj->setnConsecutivo(1);
    $obj->setsSerie($arrayDataPost['txtSerie']);
    $obj->setnMetodoPago($arrayDataPost['cmbMetodoPago']);
    $obj->setsnMetodoPago( $scmbMetodoPago);
    $obj->setnFormaPago($arrayDataPost['cmbFormaPago']);
    $obj->setsnFormaPago( ($scmbFormaPago));
    $obj->setnCFDI($arrayDataPost['cmbCFDI']);
    $obj->setsnCFDI( ($scmbCFDI));
    $obj->setnProducto($arrayDataPost['cmbProducto']);
    $obj->setsnProducto( ($scmbProducto));
    $obj->setnIVA($arrayDataPost['cmbIVA']);
    $obj->setnIdFactura($arrayDataPost['idFacturacionTAE']);
    $obj->setnTipoFactura(1);
    $tae=1;
}
if(isset($arrayDataPost['txtSerieS'])){
    $scmbMetodoPagoS = explode("(", utf8_decode($arrayDataPost['scmbMetodoPagoS']) );
    $scmbMetodoPagoS = str_replace(')',"",str_replace('(',"",$scmbMetodoPagoS[1]));
    $scmbFormaPagoS = explode("(", utf8_decode($arrayDataPost['scmbFormaPagoS']) );
    $scmbFormaPagoS = str_replace(')',"",str_replace('(',"",$scmbFormaPagoS[1]));
    $scmbCFDIS = explode("(", utf8_decode($arrayDataPost['scmbCFDIS']) );
    $scmbCFDIS = str_replace(')',"",str_replace('(',"",$scmbCFDIS[1]));
    $scmbProductoS = explode(" ", utf8_decode($arrayDataPost['scmbProductoS']) );
    $scmbProductoS =  $scmbProductoS[0]; 

    $obj->setnConsecutivoServicio(1);
    $obj->setsSerieServicio($arrayDataPost['txtSerieS']);
    $obj->setnMetodoPagoServicio($arrayDataPost['cmbMetodoPagoS']);
    $obj->setsnMetodoPagoServicio( ($scmbMetodoPagoS));
    $obj->setnFormaPagoServicio($arrayDataPost['cmbFormaPagoS']);
    $obj->setsnFormaPagoServicio( ($scmbFormaPagoS));
    $obj->setnCFDIServicio($arrayDataPost['cmbCFDIS']);
    $obj->setsnCFDIServicio( ($scmbCFDIS));
    $obj->setnProductoServicio($arrayDataPost['cmbProductoS']);
    $obj->setsnProductoServicio( ($scmbProductoS));
    $obj->setnIVAServicio($arrayDataPost['cmbIVAS']);
    $obj->setnIdFacturaServicio($arrayDataPost['idFacturacionServicios']);
    $obj->setnTipoFacturaServicio(2);
    $servicios=1;
}



$result=$obj->guardar($tae,$servicios);
echo json_encode(array(
    'bExito'	=> true,
    'nCodigo'	=> 0,
    'sMensaje'	=> 'Ok',
    'data'     => utf8ize($result)
));
?>