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
class tiendas{
    private $setCknCadenas;
    function setCknCadenas($setCknCadenas){
        $this->setCknCadenas=$setCknCadenas;
    }    
    function buscaTiendas(){
	include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
                $param = array
                (    
	                 array(
	                'name'	=> 'CknCadenas',
	                'type'	=> 's',
	                'value'	=> "".$this->setCknCadenas."")    
                );
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_notificaciones_datsucursal');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();                
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;
        return $ArrayRetorno;   
    }  
}

$obj = new tiendas();
$obj->setCknCadenas( (string) $_POST['CknCadenas']);
$result=$obj->buscaTiendas();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
)); 
?>