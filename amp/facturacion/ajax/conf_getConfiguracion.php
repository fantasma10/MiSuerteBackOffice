<?php 

class conf_getConfiguracion{

    function getConfiguracion(){
        include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
        $oRAMP->setSDatabase('aquimispagos');
        $paramServicio = array
                (
                    array(
                        'name'  => 'ckh_tipoCfg',
                        'type'  => 'i',
                        'value' => 0)
                );

        $oRAMP->setSStoredProcedure('SP_select_cfg_factura');
        $oRAMP->setParams($paramServicio);
        $result2 = $oRAMP->execute();
        //print_r($result2);
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
    'data'		=> $result
));
?>