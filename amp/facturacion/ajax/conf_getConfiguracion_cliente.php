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
class conf_getConfiguracion{

    function getConfiguracion(){
        include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
        $oRAMP->setSDatabase('aquimispagos');
        $oRAMP->setSStoredProcedure('SP_select_cfg_facturacion_cliente');
        $result2 = $oRAMP->execute();
        var_dump($result2);
        $data['Resp']  = $oRAMP->fetchAll();
        $oRAMP->closeStmt();
        return $data;
    }

}
$obj = new conf_getConfiguracion();
$result=$obj->getConfiguracion();
echo json_encode(array(
    'bExito'	=> true,
    'nCodigo'	=> 0,
    'sMensaje'	=> 'Ok',
    'data'		=> utf8ize($result)
));
?>