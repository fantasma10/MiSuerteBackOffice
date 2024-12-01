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
class gestionCreditosRegistrarPago{
    private $setidsMovimiento;
    private $setCksMontoPago;
    private $setCksSaldoDespuesPago;
    private $setCknFolioRecibo;
    private $setCkfecha;
    private $setnIdusuarioRE;
    function setidsMovimiento($setidsMovimiento){
        $this->setidsMovimiento=$setidsMovimiento;
    }   
    function setCksMontoPago($setCksMontoPago){
        $this->setCksMontoPago=$setCksMontoPago;
    } 
    function setCksSaldoDespuesPago($setCksSaldoDespuesPago){
        $this->setCksSaldoDespuesPago=$setCksSaldoDespuesPago;
    } 
    function setCknFolioRecibo($setCknFolioRecibo){
        $this->setCknFolioRecibo=$setCknFolioRecibo;
    } 
    function setCkfecha($setCkfecha){
        $this->setCkfecha=$setCkfecha;
    }   
    function setnIdusuarioRE($setnIdusuarioRE){
        $this->setnIdusuarioRE=$setnIdusuarioRE;
    }    
    function gestionRegistrar(){
	include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");             
                $param = array
                (    
	                array(
	                'name'	=> 'CkidsMovimiento',
	                'type'	=> 's',
	                'value'	=> $this->setidsMovimiento),
                    array(
                    'name'  => 'CksMontoPago',
                    'type'  => 's',
                    'value' => $this->setCksMontoPago),
                    array(
                    'name'  => 'CksSaldoDespuesPago',
                    'type'  => 's',
                    'value' => $this->setCksSaldoDespuesPago),
                    array(
                    'name'  => 'CknFolioRecibo',
                    'type'  => 's',
                    'value' => $this->setCknFolioRecibo),
                    array(
                    'name'  => 'Ckfecha',
                    'type'  => 's',
                    'value' => $this->setCkfecha),
                    array(
                    'name'  => 'CknIdusuarioRE',
                    'type'  => 's',
                    'value' => $this->setnIdusuarioRE) 
                );
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_insert_solicitud_credito_pago');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();                
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;
        return $ArrayRetorno;   
    }  
}

$obj = new gestionCreditosRegistrarPago();
$obj->setidsMovimiento($_POST['idsMovimiento']);
$obj->setCksMontoPago($_POST['CksMontoPago']);
$obj->setCksSaldoDespuesPago($_POST['CksSaldoDespuesPago']);
$obj->setCknFolioRecibo($_POST['CknFolioRecibo']);
$obj->setCkfecha($_POST['Ckfecha']);
$obj->setnIdusuarioRE($_POST['CknIdusuarioRE']);
$result=$obj->gestionRegistrar();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Pago Registrado.',
    'data'      => utf8ize($result)
));

?>