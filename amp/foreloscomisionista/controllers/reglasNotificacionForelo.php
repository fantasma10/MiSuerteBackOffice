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
class reglasNotificacionForelo{
    private $setnIdUsuario;
    function setnIdUsuario($setnIdUsuario){
        $this->setnIdUsuario=$setnIdUsuario;
    }    
    function reglasNotificacionForeloDet(){
	include_once($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");             
                $param = array
                (    
	                 array(
	                'name'	=> 'CknIdUsuario',
	                'type'	=> 's',
	                'value'	=> $this->setnIdUsuario)    
                );
                $oRAMP->setSDatabase('aquimispagos');
                $oRAMP->setSStoredProcedure('sp_select_reglasOperacion');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
                $ArrayRetorno['data'] = $data;
        return $ArrayRetorno;   
    }  
}

$obj = new reglasNotificacionForelo();
$obj->setnIdUsuario($_POST['nIdUsuario']);
$result=$obj->reglasNotificacionForeloDet();
echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));

?>