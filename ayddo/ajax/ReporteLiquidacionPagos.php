<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

if ($_POST){
	
        $array_params = array(
                array(
                        'name'	=> 'p_nIdMetodpago',
                        'type'	=> 'i',
                        'value'	=> $_POST['idProveedor']
                ),
                array(
                        'name'	=> 'p_dFechaInicio',
                        'type'	=> 's',
                        'value'	=> $_POST['dFechaInicio']
                ),
                array(
                        'name'	=> 'p_dFechaFin',
                        'type'	=> 's',
                        'value'	=> $_POST['dFechaFin']
                )
                );
                
                $oRDPN->setSDatabase('paycash_one');
                $oRDPN->setSStoredProcedure("sp_select_liquidacion_mediopago");
                $oRDPN->setParams($array_params);

                $result = $oRDPN->execute();
                $data = $oRDPN->fetchAll();
                $data =utf8ize($data);
}
echo json_encode($data );