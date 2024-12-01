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
class operadores{
    private $setCknTiendas;
    private $setCknTipoUsuario;
    function setCknTiendas($setCknTiendas){
        $this->setCknTiendas=$setCknTiendas;
    }    
    function setCknTipoUsuario($setCknTipoUsuario){
        $this->setCknTipoUsuario=$setCknTipoUsuario;
    }    
    function buscaTiendas(){
	include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");     
                $param = array
                (    
	                array(
	                'name'	=> 'CknTiendas',
	                'type'	=> 's',
	                'value'	=> "".$this->setCknTiendas.""),
                    array(
                    'name'  => 'CknTipoUsuario',
                    'type'  => 's',
                    'value' => $this->setCknTipoUsuario)    
                );
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_notificaciones_datoperador');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();                
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;
        return $ArrayRetorno;   
    }  
}

$obj = new operadores();
$obj->setCknTiendas( (string) $_POST['CknTiendas']);
$obj->setCknTipoUsuario( $_POST['CknTipoUsuario'] );
$result=$obj->buscaTiendas();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
)); 
?>