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
class detalleCorteDiarioForelo{
    private $setnIdUsuario;
    private $setnNumCuenta;
    private $setdFechaInicio;
    private $setdFechaFinal;
    function setnIdUsuario($setnIdUsuario){
        $this->setnIdUsuario=$setnIdUsuario;
    }
    function setnNumCuenta($setnNumCuenta){
        $this->setnNumCuenta=$setnNumCuenta;
    } 
    function setdFechaInicio($setdFechaInicio){
        $this->setdFechaInicio=$setdFechaInicio;
    } 
    function setdFechaFinal($setdFechaFinal){
        $this->setdFechaFinal=$setdFechaFinal;
    }    
    function buscaMovimientos(){
	include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");             
                $param = array
                (    
                    array(
                    'name'  => 'Ck_nNumCuenta',
                    'type'  => 's',
                    'value' => $this->setnNumCuenta),
                    array(
                    'name'  => 'Ck_dFechaInicio',
                    'type'  => 's',
                    'value' => $this->setdFechaInicio),
                    array(
                    'name'  => 'Ck_dFechaFinal',
                    'type'  => 's',
                    'value' => $this->setdFechaFinal),
                    array(
                    'name'  => 'nIdEstatus',
                    'type'  => 'i',
                    'value' => '1'),
                    array(
                    'name'  => 'nIdTipoCobro',
                    'type'  => 'i',
                    'value' => '1'),
                    array(
                    'name'  => 'nIdTipoMovimiento',
                    'type'  => 'i',
                    'value' => '0'),
                    array(
                    'name'  => 'str',
                    'value' => '',
                    'type'  => 's'),
                    array(
                    'name'  => 'start',
                    'value' => '0',
                    'type'  => 'i'),
                    array(
                    'name'  => 'limit',
                    'value' => '20',
                    'type'  => 'i'),
                    array(
                    'name'  => 'sortCol',
                    'value' => '2',
                    'type'  => 'i'),
                    array(
                    'name'  => 'sortDir',
                    'value' => 'DESC',
                    'type'  => 's')
                );  
                //print_r($param); die();
                $oRAMP->setSDatabase('redefectiva');
                $oRAMP->setSStoredProcedure('sp_select_movimientos_credito');
                $oRAMP->setParams($param);
                
                $result2 = $oRAMP->execute(); //print_r($result2); die();
                $data = $oRAMP->fetchAll();   
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;
        return $ArrayRetorno;   
        
    }  
}

$obj = new detalleCorteDiarioForelo();

$obj->setnIdUsuario($_POST['Ck_nIdUsuario']);
$obj->setnNumCuenta($_POST['Ck_nNumCuenta']);
$obj->setdFechaInicio($_POST['Ck_dFechaInicio']);
$obj->setdFechaFinal($_POST['Ck_dFechaFinal']);

$result=$obj->buscaMovimientos();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));

?>