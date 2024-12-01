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
class forelosComisionista{
    private $setsBusc;
    function setsBusc($setsBusc){
        $this->setsBusc=$setsBusc;
    }    
    function buscaCom(){
	include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");   
                $param = array
                (    
	                 array(
	                'name'	=> 'CksBusca',
	                'type'	=> 's',
	                'value'	=> $this->setsBusc)    
                );

                // $oRAMP->setSDatabase('data_AquiMisPagos');
                //$oRAMP->setSStoredProcedure('sp_select_consultarComisionista');
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_consultar_Comisionista'); // ok - No ocupa WS. El SP trae todo.

                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;
        return $ArrayRetorno;   
    }  
}

$obj = new forelosComisionista();
$obj->setsBusc($_POST['buscaComisionista']);
$result=$obj->buscaCom();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));

?>